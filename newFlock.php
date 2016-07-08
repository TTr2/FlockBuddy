<?php
require_once 'autoload.php';

/* New flock - Adds a flock to the database.
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */


if (isset($_POST)){
    
    $flockTable = new FlockTable();
    $sheepTable = new SheepTable();
    
    $flockID = $flockTable->getNextFlockID(); // TALK TO DB AND GET AUTOINCREMENT FOR FLOCK ID

    $sheepMobile = '44' . substr($_POST['mobile'], 1);
    $shepherdID = $flockID . $sheepMobile;

    $shepherd = new Sheep ( $shepherdID, $sheepMobile, $_POST['sheepName'],
            NULL, // Longtitude
            NULL, // Latitude
            true, // Accepted by default
            true, // Tracking by Default
            true, // Is Shepherd
            $flockID); // FlockID


    if ($sheepTable->addSheep($shepherd)){

        $flock = new Flock( $flockID,
            $_POST['flockName'],
            $shepherdID,
            $_POST['start'],
            $_POST['end'],
            $_POST['maxDistance']);

        if ($flockTable->addFlock($flock)){
            http_response_code(200);
        }
        else{
            http_response_code(400);
        }
    }
    else{
        http_response_code(400);
    }

    var_dump(http_response_code());

}