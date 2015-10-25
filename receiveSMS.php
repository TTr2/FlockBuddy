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
    
    $sheepTable = new $sheepTable();
    $flockTable = new $flockTable();
    
    $sheepMobile = $_POST['from'];
    $messageFromSheep = $_POST['content'];

    $sheep = $sheepTable->getSheepUsingSheepMobile($sheepMobile);
    $flock = $flockTable->getFlockUsingFlockID($sheep->getFlockID());
    
    switch ($messageFromSheep){
        case "OK":
            $sheepTable->confirmSheepAceeptance($sheep->getSheepID());
// 
// Set App play package name address.
// http://developer.android.com/distribute/tools/promote/linking.html#OpeningDetails
//            
            $messageToSheep = "Great, you have joined the " . $flock->getFlockName() 
                . " flock! To start tracking, follow http://play.google.com/store/apps/details?id=<package_name> and remember to enable tracking.";
            try {
                $sendSheepMessage = new Message($sheepMobile, $lostmessageToSheep);            
            } catch (ClockworkException $e) {
                echo 'Exception sending SMS: ' . $e->getMessage();
            }
            break;
        case "STOP":
            // Remove sheep from DB
            // If successful, send msg confirming exit and reminder to disable tracking.
            break;
        case "SUSPEND":
            $sheepTable->toggleSheepTracking($sheepID, false);
            
            // Set tracking to false for this sheep.
            // Send reminder SMS after an hour? Strat cron job ?
            break;
    }    
}

