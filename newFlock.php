<?php
require_once 'autoload.php';

/* New flock - Adds a flock to the database.
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */


if (isset($_POST)){

    $flockID = "123"; // TALK TO DB AND GET AUTOINCREMENT FOR FLOCK ID
    $shepherdID = "123"; // TALK TO DB AND GET AUTOINCREMENT FOR SHEEP ID
    
    $shepherd = new Sheep ( $shepherdID, $_POST[shepardMob], $flockID, $_POST[sheepName],
            NULL, // Longtitude
            NULL, // Latitude
            true, // Accepted by default
            true, // Tracking by Default
            true); // Is Shepherd


    $flock = new Flock( $flockID, 
                        $_POST[flockName], 
                        $shepherd->getSheepID(),
                        $_POST[start],
                        $_POST[end], 
                        $_POST[maxDistance]);
    
    //
    // DATABASE TABLE METHOD TO ADD FLOCK
    //

    //
    // RETURN INFO TO ANDROID VIA HTTP
    // Return $flockID
    //
    

    
    

    
    
}