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
    
    $sheepID = $flockID . $_POST['mobile']; // Composite Key
    
    $sheep = new Sheep ( $sheepID, $_POST['mobile'], $flockID, $_POST['sheepName'],
            NULL, // Longtitude
            NULL, // Latitude
            false, // By default
            false, // By Default
            false); // Not a Shepherd
    
    if ($sheepTable->addSheep($sheep)){
        http_response_code(200);
        echo "Success";

        $messageForSheep = "You have been added to the " 
                . $flock->getFlockName() 
                . " Flock, reply \"OK\" to this message to enable tracking.";
        $sheepMobile = $_POST['mobile'];

        try{
           $sendMessage = new Message($sheepMobile, $messageForSheep);            
        } catch (ClockworkException $e) {
            echo 'Exception sending SMS: ' . $e->getMessage();
        }
    }
    else{
        http_response_code(400);        
        echo " FAIL";        
    }
}