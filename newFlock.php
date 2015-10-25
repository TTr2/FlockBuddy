<?php
require_once 'autoload.php';

/* New flock - Adds a flock to the database.
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */


if (isset($_POST)){
    
    $flockTable = new FlockTable();
    
    $flockID = $flockTable->getNextFlockID(); // TALK TO DB AND GET AUTOINCREMENT FOR FLOCK ID
    $shepherdID = $flockID . $_POST[mobile];
    
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
    
    if ($flockTable->addFlock($flock)){
        http_response_code(200);
    }
    else{
        http_response_code(400);        
    }
    
}