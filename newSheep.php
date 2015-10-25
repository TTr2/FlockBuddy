<?php
require_once 'autoload.php';
/* New Sheep - adds a sheep to the flock. 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

if (isset($_POST)){

    $sheepTable = new SheepTable(); 
    
    $flockID = $_POST[flockID];
    $sheepID = $flockID . $_POST[mobile]; // Composite Key
    
    $sheep = new Sheep ( $sheepID, $_POST[sheepMob], $flockID, $_POST[sheepName],
            NULL, // Longtitude
            NULL, // Latitude
            false, // By default
            false, // By Default
            false); // Not a Shepherd
    
    if ($sheepTable->addSheep($sheep)){
        http_response_code(200);
    }
    else{
        http_response_code(400);        
    }
}