<?php
require_once 'autoload.php';
/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Processes SMS messages sent by Sheep via Clockwork.
 * @author Tim Tyler
 */


if (isset($_POST)){
    
    $sheepTable = new SheepTable();
    $flockTable = new FlockTable();
    
    $sheepMobile = $_POST['from'];
    $sheep = $sheepTable->getSheepUsingSheepMobile($sheepMobile);

    $flock = $flockTable->getFlockUsingFlockID($sheep->getFlockID());

    $messageFromSheep = strtoupper($_POST['keyword']);
    $messageForSheep = "Sorry, something seems to have gone wrong. Please try again or contact support@flockbuddy.com";

    switch ($messageFromSheep){

        case "FLOCKME":

            if ($sheepTable->checkSheepAcceptance($sheepID)){
                if ($sheepTable->toggleSheepTracking($sheep->getSheepID(), 1)) {
                    // TODO limit to 160 characters
                    $messageForSheep = "Welcome back to the '" . $flock->getFlockName()
                        . "' flock! To suspend tracking again, text 'SUSPEND' to 84433 (Texts cost 10p)."
                        . "Confused? Find out more at www.flockbuddy.com";
                }
            }
            elseif ($sheepTable->confirmSheepAcceptance($sheep->getSheepID())){

                // TODO Set App play package name address.
                // http://developer.android.com/distribute/tools/promote/linking.html#OpeningDetails


                // TODO limit to 160 characters
                 $messageForSheep = "Great, you have joined the '" . $flock->getFlockName()
                    . "' flock! Tracking will begin at " . $flock->getFlockStart() . " To suspend tracking, text 'SUSPEND' to 84433 (Texts cost 10p). "
                . "Now install http://play.google.com/store/apps/details?id=<package_name>. "
                . "Confused? Find out more at www.flockbuddy.com";
             }
            break;

        case "FLOCKMENOT": // User rejection message, remove sheep from database.

            $shepherd = $flock->getShepherd();

            // Check if sheep cancelling is the shepherd.
            if ($sheep->getSheepID() === $shepherd->getSheepID()){

                $shepherdsFlock = $sheepTable->getAllSheepFromFlockID($flock->getFlockID());

                // TODO limit to 160 characters
                $messageForSheep = "Your flock has been cancelled by your shepherd - thanks for being a good sheep!"
                    . " Confused? Find out more at www.flockbuddy.com";

                foreach ( $shepherdsFlock as $sheepInFlock){
                    if ($sheepTable->deleteSheepFromTable($sheepInFlock->getSheepID())){
                        try{
                            // Create a Clockwork object using your API key
                            $clockwork = new Clockwork('787b4673e0ac4b043aab8a4764f0205ab06dc309');

                            // Setup and send a message
                            $message = array('to' => $sheepInFlock->getSheepID(), 'message' => $messageForSheep);
                            $result = $clockwork->send($message);

                            // Check if the send was successful
                            if ($result['success']) {
                                echo 'Message sent - ID: ' . $result['id'];
                            } else {
                                echo 'Message failed - Error: ' . $result['error_message'];
                            }

                        } catch (ClockworkException $e) {
                            echo 'Exception sending SMS: ' . $e->getMessage();
                        }
                    }
                }
                if ($sheepTable->deleteSheepFromTable($shepherd->getSheepID())){
                    // TODO limit to 160 characters
                    $messageForSheep = "Your flock has been cancelled, your sheep will be notified. To create a new flock go to the FlockBuddy app."
                        . " Confused? Find out more at www.flockbuddy.com";
                }
            }

            // Sheep cancelling is not the shepherd
            elseif ($sheepTable->deleteSheepFromTable($sheep->getSheepID())) {
                // TODO limit to 160 characters
                $messageForSheep = "Aw shucks, you have declined to join the '" . $flock->getFlockName()
                    . "' flock. To change your mind, ask " . $shepherd->getSheepName()
                    . " to add you to the flock again on +" . $shepherd->getSheepMobile()
                    . ". Confused? Find out more at www.flockbuddy.com";
            }
            break;

        case "SUSPEND":
            // TODO Decide if this is sent via SMS or in app?
            // TODO Send reminder SMS after an hour? Start cron job ?
            // Set tracking to false for this sheep.
            if ($sheepTable->toggleSheepTracking($sheep->getSheepID(), 0)) {
                // TODO limit to 160 characters
                $messageForSheep = "You have suspended tracking from the '" . $flock->getFlockName()
                    . "' flock! To suspend tracking, text 'SUSPEND' to 84433 (Texts cost 10p). "
                    . "Now install http://play.google.com/store/apps/details?id=<package_name>. "
                    . "Confused? Find out more at www.flockbuddy.com";
            };
            break;
    }

    try {
        // Create a Clockwork object using your API key
        $clockwork = new Clockwork('787b4673e0ac4b043aab8a4764f0205ab06dc309');

        // Setup and send a message
        $message = array('to' => $sheepMobile, 'message' => $messageForSheep);
        $result = $clockwork->send($message);

        // Check if the send was successful
        if ($result['success']) {
            echo 'Message sent - ID: ' . $result['id'];
        } else {
            echo 'Message failed - Error: ' . $result['error_message'];
        }

    } catch (ClockworkException $e) {
        echo 'Exception sending SMS: ' . $e->getMessage();
    }

}

