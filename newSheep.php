<?php
require_once 'autoload.php';
/* New Sheep - adds a sheep to the flock. 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

if (isset($_POST)){

    // FLOCK + MOBILE
    $nextSheepID = "123"; // TALK TO DB AND GET AUTOINCREMENT FOR SHEEP ID
    
    $sheep = new Sheep ( $nextSheepID, $_POST[sheepMob], $_POST[flockID], $_POST[sheepName],
            NULL, // Longtitude
            NULL, // Latitude
            false, // By default
            false, // By Default
            false); // Not a Shepherd

    //
    // Check for mobile in active flocks before adding.
    //
        
    $flock = new Flock( $flockID, 
                        $_POST[flockName], 
                        $shepherd->getSheepID(),
                        $_POST[start],
                        $_POST[end], 
                        $_POST[maxDistance]);
    
    //
    // DATABASE TABLE METHOD TO ADD SHEEP
    //

    //
    // RETURN INFO TO ANDROID VIA HTTP?
    //
    

    
    

    
    
}