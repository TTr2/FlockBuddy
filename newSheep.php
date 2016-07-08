<?php
require_once 'autoload.php';
/* New Sheep - adds a sheep to the flock. 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

if (isset($_POST)){

    $sheepTable = new SheepTable(); 
    $flockTable = new FlockTable(); 
    
    $flockID = $_POST['flockID'];
    $flock = $flockTable->getFlockUsingFlockID($flockID);

    $sheepMobile = '44' . substr($_POST['mobile'], 1);

    $sheepID = $flockID . $sheepMobile; // Composite Key

    $sheep = new Sheep ( $sheepID, $sheepMobile, $_POST['sheepName'],
            NULL, // Longtitude
            NULL, // Latitude
            false, // Not Accepted by default
            false, // Not Tracking by Default
            false, // Not a Shepherd
            $flockID); // FlockID

    
    if ($sheepTable->addSheep($sheep)){
        http_response_code(200);

        $messageForSheep = "You have been added to the '" . $flock->getFlockName() . "' Flock by "
            . $flock->getShepherd()->getSheepName()
            . ". To enable tracking permission, text \"FLOCKME\" to 84433 (Texts cost 10p). Confused? Find out more at www.flockbuddy.com";

        try {
            // Create a Clockwork object using your API key
            $clockwork = new Clockwork('787b4673e0ac4b043aab8a4764f0205ab06dc309');

            // Setup and send the message
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
    else{
        http_response_code(400);        
        echo " FAILED to add sheep to flock.";
    }
}