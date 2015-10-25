<?php
require_once 'autoload.php';

class FlockTable extends TableAbstract{

function __construct() {
    parent::__construct();
}
    
function addFlock($flock) {
    
    $sql = "INSERT INTO flock (flockID, flockName,flockStart,flockEnd, flockRadius) 
            VALUES (:flockID, :flockName, :flockStart, :flockEnd, :flockRadius)";
    $params = array(
        ':flockID' => $flock->getFlockID(),
        ':flockName' => $flock->getFlockName(),
        ':flockStart' => $flock->getFlockStart(),
        ':flockEnd' => $flock->getFlockEnd(),
        ':flockRadius' => $flock->getFlockRadius()
    );
    $result = $this->dbh->prepare($sql);
    $result->execute($params);

    if ($result->errorCode()==0) {
        return TRUE;             
    }
    return FALSE;    
}

function getNextFlockID(){
    $sql = "SELECT COUNT(*) FROM flock";
    $result = $this->dbh->prepare($sql);
    $result->execute();
    $value = $result->fetch(PDO::FETCH_BOTH);
    return ($value[0] + 1);    
}

function getFlockUsingFlockID($flockID) {

    $sql = "SELECT * FROM flock WHERE flockID == :flockID";
    $params = array(
        ':flockID' => $flockID
    );
    $result = $this->dbh->prepare($sql);
    $result->execute($params);
//    $values->fetch(PDO::FETCH_BOTH);
    $values = $result->fetch(PDO::FETCH_BOTH);
    if ($result->errorCode()==0) {   
        $flock = new Flock ( 
            $values[0], // flockID
            $values[1], // flockName
            $values[3], // flockStart
            $values[4], // flockEnd
            $values[5]); // flockRadius
        return $flock;         
    }
    return NULL;
}

function deleteFlockFromTable($flockID) {
    $sql = "DELETE FROM flock WHERE 'flockID' = :flockID";
    $params = array(
    ':flockID' => $flockID
    );
    $result = $this->dbh->prepare($sql);
    $result->execute($params);

    if ($result->errorCode()==0) {
        return TRUE;             
    }
    return FALSE; 
}


    function getAllFlocks($sheepID){
        $sql = "SELECT * FROM flock WHERE flockShepherdID = :sheepID";
        $params = array(
            ':flockShepherdID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $values->fetch(PDO::FETCH_BOTH);
        $flocks[] = array();
        if ($result->errorCode()==0) {
            $count = 0;
            foreach ($values as $row){
                $flock = new Flock ( 
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5]);
                $flocks[$count++] = $flock;
            }
        return $flocks;         
        }
        return null;                
    }    

    function countSheepInFlock($flockID){
        $sql = "SELECT COUNT(*) FROM sheep WHERE flockID = :flockID";
        $params = array(
            ':flockID' => $flockID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $count = $result->fetch(PDO::FETCH_BOTH);
        return $count[0];
    }
    
    
    function buildFlocksXML($flocks){
        $response = '<?xml version="1.0" encoding="utf-8"?>';
        foreach ($flocks as $flock){
            $flockName = $flock->getFlockName();
            $flockStart = $flock->getFlockStart();
            $flockEnd = $flock->getFlockEnd();
            $count = countSheepinFlock($flock->getFlockID());
            $response = $response
                    . "<flock>"
                    . "<name>$flockName</name>"
                    . "<start>$flockStart</start>"
                    . "<end>$flockEnd</end>"
                    . "<count>$count</count>"
                    . "</flock>";        
        }
        return $response;
    }   

}
