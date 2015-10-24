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
    
    // Locate flock and sheep.
    
    $flockID = $_POST[flockID];
//    
//    findFlock searches DB for flockID and returns an instantiated Flock object on its data. 
//    Needs reference e.g. FlockTable.php
    $flock = findFlock($flockID);
    if ($flock !== null){
        
    }

    $sheepID = $_POST[sheepID] . $_POST[mobile];
//    
//    findSheep searches DB for sheepID and returns an instantiated Sheep object on its data. 
//    Needs reference e.g. SheepTable.php
    $sheep = findSheep($sheepID);

    $oldX = $sheep->getSheepLongtitude();        
    $oldY= $sheep->getSheepLatitude();
    
    $newX = $_POST[longtitude];
    $newY = $_POST[latitude];
    //
    // UPDATE DB WITH NEW COORDS
    // $sheepTable->updateCoords(Sheep, longtitude, latitude);
    
    $shepherdX = $flock->getShepherd()->getSheepLongtitude();    
    $shepherdY = $flock->getShepherd()->getSheepLatitude();
            
    $flockMaxRadius = $flock->getFlockRadius();
    $distanceFromShepherd = sqrt( 
            pow($shepherdX - $newX,2) + pow($shepherdY - $newY,2) ); 
    
    if ($distanceFromShepherd > $flockMaxRadius){
        // SEND MESSAGE.

        //
        // TRIM  MESSAGES TO 160 characters.
        //
        
        
        $lostSheepNumber = $sheep->getSheepMobile();
        $lostSheepMessage = "Oh little sheep, you have gone astray! Your Shepherd is currently " 
                . $distanceFromShepherd . "m away! You can catch up with him if you open this link "
                . "www.google.com/maps/place/". $shepherdX . "," . $shepherdY
                . ". Or why not give them a ring on " 
                . $shepherd->getSheepMobile() 
                . " so you can explain what a silly Sheep you are. Or reply to this number and write \"STOP\".";

        // Call message $lostSheepNumber / $message. 
        try {
            $sendSheepMessage = new Message($lostSheepNumber, $lostSheepMessage);            
        } catch (ClockworkException $e) {
                echo 'Exception sending SMS: ' . $e->getMessage();
        }
        
        $shepherdNumber = $shepherd->getSheepMobile();
        $shepherdMessage = "You have lost one of your sheep! " . $sheep->getSheepName() . " is currently " 
                . $distanceFromShepherd . "m away! He is currently here: "
                . "www.google.com/maps/place/". $newX . "," . $newY
                . ". You could give them a ring on " 
                . $sheep->getSheepMobile() 
                . " so you can explain what a silly Sheep they are. To stop tracking you flock, reply to this number and write \"STOP\".";        
        try {
            $sendShepherdMessage = new Message($shepherdNumber, $shepherdMessage);            
        } catch (ClockworkException $e) {
                echo 'Exception sending SMS: ' . $e->getMessage();
        }

    }
    
    
    
    
    
    
    
    
    
}