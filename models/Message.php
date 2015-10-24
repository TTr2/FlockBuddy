<?php
require_once 'autoload.php';
require 'class-Clockwork.php';
require 'class-ClockworkException.php';

/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Instantiating a message generates a ClockworkSMS.
 * @author Tim Tyler
 */
class Message  {

    protected $API_KEY = '787b4673e0ac4b043aab8a4764f0205ab06dc309';
 
    function __constructor($to, $messageToSheep){

        // Create a Clockwork object using your API key
        $clockwork = new Clockwork( $API_KEY );

        // Setup and send a message
        $message = array( 'to' => $to, 'message' => $messageToSheep );
        $result = $clockwork->send( $message );

        // Check if the send was successful
        if($result['success']) {
            echo 'Message sent - ID: ' . $result['id'];
        } else {
            echo 'Message failed - Error: ' . $result['error_message'];
        }
    }
}
    

