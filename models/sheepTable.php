<?php
require_once 'autoload.php';

function addSheep($sheep) {
    $query = mysql_query("
    INSERT INTO 'flockbuddy'.'sheep' ('sheepID', 'sheepName', 
    'sheepLongitude', 'sheepLatitude', 'accepted', 'tracking', 'isShepherd') 
    VALUES ('$sheep->getSheepID', '$sheep->getSheepName',
    '$sheep->getSheepLongitude', '$sheep->getSheepLatitude', 
    '$sheep->getAccepted', '$sheep->getTracking', 
    '$sheep->getIsShepherd');");

    if (!$query) {
            echo 'Could not run query: ' . mysql_error();
            exit;
    }
    echo "Sheep flocked successfully";
}
	
function getSheepUsingSheepID($sheepID) {

    $query = mysql_query("SELECT * FROM sheep WHERE sheepID == $sheepID);");

    if (!$query) {
            echo 'Could not run query: ' . mysql_error();
            exit;
    }
    $row = mysql_fetch_row($query); // turn row into array

    $sheep = new Sheep ( 
        $row[0], // sheepID
        $row[1], // sheepMobile
        $row[2], // sheepName
        $row[3], // sheepLongtitude
        $row[4], // sheepLatitude
        $row[5], // accepted
        $row[6], // tracking
        $row[7], // isShepherd
        $row[8]); // flockID 

    return $sheep; 
}

function getSheepUsingSheepMobile($sheepMobile) {

    $query = mysql_query("SELECT * FROM sheep WHERE sheepMobile == $sheepMobile);");

    if (!$query) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    $row = mysql_fetch_row($query); // turn row into array

    $sheep = new Sheep ( 
        $row[0], // sheepID
        $row[1], // sheepMobile
        $row[2], // sheepName
        $row[3], // sheepLongtitude
        $row[4], // sheepLatitude
        $row[5], // accepted
        $row[6], // tracking
        $row[7], // isShepherd
        $row[8]); // flockID 

    return $sheep; 
}

function deleteSheepFromTable($sheepID) {

    $query = mysql_query("DELETE FROM sheep WHERE 'sheepID' == $sheepID);");

    if (!$query) {
        echo 'Could not run query: ' . mysql_error();
        exit;
    }
    echo "Sheep deleted successfully"; 
}

function getSheepLongitude($sheepID) {
    
    $query = mysql_query("SELECT sheepLongitude FROM sheep 
    WHERE sheepID == $sheepID);");
    
    return $query;
}

function getSheepLatitude($sheepID) {
    
    $query = mysql_query("SELECT sheepLatitude FROM sheep 
    WHERE sheepID == $sheepID);");    
    
    return $query;
}

function getSheepName($sheepID) {
    
    $query = mysql_query("SELECT sheepName FROM sheep 
    WHERE sheepID == $sheepID);");    
    
    return $query;
}

function getSheepMobile($sheepID) {
    
    $query = mysql_query("SELECT sheepMobile FROM sheep 
    WHERE sheepID == $sheepID);");    
    
    return $query;
}


	
	