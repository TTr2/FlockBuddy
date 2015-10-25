<?php

/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */ 

/**
 * Returns an XML object containing all sheep in given flock.
 * @author Tim Tyler
 */
require_once 'autoload.php';

if (isset($_POST)){
    $sheepTable = new SheepTable();
    $sheeps[] = $sheepTable->getAllSheeps($_POST['flockID']);    
    echo $sheepTable->buildSheepsXML($sheeps);
}

