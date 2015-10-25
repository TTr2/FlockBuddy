<?php
require_once 'autoload.php';
/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Toggles tracking by the server for a sheep.
 * @author Tim Tyler
 */

if (isset($_POST)){
    
    $sheepTable = new SheepTable();
    
    $sheep = $sheepTable->getSheepUsingSheepMobile($_POST['mobile']);
    $sheepTable->toggleSheepTracking($sheep->getSheepID(), $tracking);     
}
