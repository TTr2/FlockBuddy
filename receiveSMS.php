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
    
    $sheepMobile = $_POST[from];
    $messageFromSheep = $_POST[content];    
//    
//    findFlock searches DB for flockID and returns an instantiated Flock object on its data. 
//    Needs reference e.g. FlockTable.php
//
    $sheep = findSheepFromMobile($sheepMobile);
    $flock = $sheep->getSheepFlock();
    
    switch ($messageFromSheep){
        case "OK":
// Update sheep accepted, tracking to true.
// Send SMS confirmer, reminder to enable tracking.

// 
// Set App play package name address.
// http://developer.android.com/distribute/tools/promote/linking.html#OpeningDetails
//            
            $messageToSheep = "Great, you have joined the " . $flock->getFlockName() 
                . " flock! To start tracking, follow http://play.google.com/store/apps/details?id=<package_name>";
            break;
            // Send message ($sheepMobile, $messageToSheep;
        case "STOP":
            // Remove sheep from DB
            // If successful, send msg confirming exit and reminder to disable tracking.
            break;
        case "SUSPEND":
            // Set tracking to false for this sheep.
            // Send reminder SMS after an hour? Strat cron job ?
            break;
    }
    
    
    
    
    
}

// OK msg, STOP msg, SUSPEND msg

// STOP MESSAGE SHOULD CHECK IF SHEEP IS SHEPHERD, TO CANCEL FLOCK.


/*
Receive SMS

Our API will forward each incoming message to a server of your choosing by making a simple HTTP GET or POST request. All the parameters will be URL-Encoded UTF-8 text. Your server needs to respond with a 200 OK status code to acknowledge receipt of the message, otherwise the API will retry at regular intervals.

Parameters

To

Your long number or shortcode

From

Phone number that sent the message, this will be in international format e.g. 441625588620.

Content

Text of the message

Msg_ID

Unique ID Clockwork assigned to the message, use this if you want to raise a query and to make sure you don't receive any duplicates.

Keyword

If you're using a shared shortcode we'll pass across the keyword that was matched. For dedicated numbers this isn't used.

Example URL

http://www.example.com/receive-sms?to=84433&from=441234567890&content=Hello+World&keyword=hello&msg_id=AB_12345
 */