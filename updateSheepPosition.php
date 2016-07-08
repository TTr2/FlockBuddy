<?php
require_once 'autoload.php';
/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Updates tracking info for one sheep, then analyses distances from Shepherd
 * - can trigger lost sheep message if distance is > maxRadius.
 * @author Tim Tyler
 */


if (isset($_POST)){
    
    $flockTable = new FlockTable();
    $sheepTable = new SheepTable();
    $geoDistance = new GeoDataSource();

    $sheepMobile = '44' . substr($_POST['mobile'], 1);
    
    // Locate flock and sheep.    
    $sheep = $sheepTable->getSheepUsingSheepMobile($sheepMobile);
    $flock = $flockTable->getFlockUsingFlockID($sheep->getFlockID());    

    $newX = $_POST['longtitude'];
    $newY = $_POST['latitude'];
    
    $sheepTable->updateSheepCoordinates($sheep->getSheepID(),$newX,$newY);

    $shepherd = $flock->getShepherd();
    $shepherdX = $shepherd->getSheepLongtitude();
    $shepherdY = $shepherd->getSheepLatitude();
            
    $flockMaxRadius = $flock->getFlockRadius();
    $distanceFromShepherd = $geoDistance->distance($newY, $newX, $shepherdY, $shepherdX, "M");

    if ($distanceFromShepherd > $flockMaxRadius){
        
        // SEND MESSAGE.
        // TODO limit to 160 characters
        $lostSheepNumber = $sheep->getSheepMobile();
        $lostSheepMessage = "Oh little sheep, you have gone astray! Your Shepherd is currently " 
                . (int)$distanceFromShepherd . "m away! You can catch up with them if you open this link "
                . "www.google.com/maps/place/". $shepherdY . "," . $shepherdX
                . ". Or why not give them a ring on +" . $shepherd->getSheepMobile()
                . " so you can explain what a silly Sheep you are. To suspend tracking, text 'SUSPEND' to 84433 (Texts cost 10p)."
                . " Confused? Find out more at www.flockbuddy.com";

        try {
            // Create a Clockwork object using your API key
            $clockwork = new Clockwork('787b4673e0ac4b043aab8a4764f0205ab06dc309');

            // Setup and send a message
            $message = array('to' => $lostSheepNumber, 'message' => $lostSheepMessage);
            $result = $clockwork->send($message);

            // Check if the send was successful
            if ($result['success']) {
                echo 'Message sent - ID: ' . $result['id'] . ' ';
            } else {
                echo 'Message failed - Error: ' . $result['error_message'] . ' ';
            }

        } catch (ClockworkException $e) {
            echo 'Exception sending SMS: ' . $e->getMessage() . ' ';
        }
        
        $shepherdNumber = $shepherd->getSheepMobile();
        // TODO limit to 160 characters
        $shepherdMessage = "You have lost one of your sheep! " . $sheep->getSheepName() . " is currently " 
                . $distanceFromShepherd . "m away! He is currently here: "
                . "www.google.com/maps/place/". $newY . "," . $newX
                . ". You could give them a ring on " 
                . $sheep->getSheepMobile() 
                . " so you can explain what a silly Sheep they are. To stop tracking your flock, reply to this number and write \"FLOCKMENOT\".";
        try {
            // Create a Clockwork object using your API key
            $clockwork2 = new Clockwork('787b4673e0ac4b043aab8a4764f0205ab06dc309');

            // Setup and send a message
            $message2 = array('to' => $shepherdNumber, 'message' => $shepherdMessage);
            $result2 = $clockwork2->send($message2);

            // Check if the send was successful
            if ($result2['success']) {
                echo 'Message sent - ID: ' . $result2['id'] . ' ';
            } else {
                echo 'Message failed - Error: ' . $result2['error_message'] . ' ';
            }

        } catch (ClockworkException $e) {
            echo 'Exception sending SMS: ' . $e->getMessage() . ' ';
        }

    }
    
    
    
    
    
    
    
    
    
}
