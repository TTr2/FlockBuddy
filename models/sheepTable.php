<?php
require_once 'autoload.php';

class SheepTable extends TableAbstract{
    
    function addSheep($sheep) {

        $sql = "INSERT INTO sheep (sheepID, flockID, sheepMobile, sheepName, sheepLongitude, sheepLatitude, accepted, tracking, isShepherd )
                VALUES (:sheepID, :flockID, :sheepMobile, :sheepName, :sheepLongitude, :sheepLatitude, :accepted, :tracking, :isShepherd)";
        $params = array(
            ':sheepID' => $sheep->getSheepID(),
            ':flockID' => $sheep->getFlockID(),
            ':sheepMobile' => $sheep->getSheepMobile(),
            ':sheepName' => $sheep->getSheepName(),
            ':sheepLongitude' => $sheep->getSheepLongtitude(),
            ':sheepLatitude' => $sheep->getSheepLatitude(),
            ':accepted' => $sheep->getAccepted(),
            ':tracking' => $sheep->getTracking(),
            ':isShepherd' => $sheep->getIsShepherd()
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        if ($result->errorCode() == 0) {
            return TRUE;             
        }
        return FALSE;    
    }
    
    function getSheepUsingSheepID($sheepID) {    
        $sql = "SELECT * FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $values = $result->fetch(PDO::FETCH_BOTH);
        if ($result->errorCode()==0) {   
            $sheep = new Sheep (
                $values[0], // sheepID
                $values[1], // sheepMobile
                $values[2], // sheepName
                $values[3], // sheepLongtitude
                $values[4], // sheepLatitude
                $values[5], // accepted
                $values[6], // tracking
                $values[7], // isShepherd
                $values[8] // flockID
            );
            return $sheep;         
        }
        return NULL;
    }
   

   
    function getSheepUsingSheepMobile($sheepMobile) {
        $sql = "SELECT * FROM sheep WHERE sheepMobile = :sheepMobile ORDER BY flockID DESC LIMIT 1";
        $params = array(
            ':sheepMobile' => $sheepMobile
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $values = $result->fetch(PDO::FETCH_BOTH);

        if ($result->errorCode()==0) {
            $sheep = new Sheep (
                $values[0], // sheepID
                $values[1], // sheepMobile
                $values[2], // sheepName
                $values[3], // sheepLongtitude
                $values[4], // sheepLatitude
                $values[5], // accepted
                $values[6], // tracking
                $values[7], // isShepherd
                $values[8] // flockID
            );
            return $sheep;
        }
        return NULL;
    }

    function deleteSheepFromTable($sheepID) {
        $sql = "DELETE FROM sheep WHERE 'sheepID' = :sheepID";

        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        if ($result->errorCode()==0) {
            return TRUE;             
        }
        return FALSE; 
    }

    function updateSheepCoordinates($sheepID, $sheepLongitude, $sheepLatitude) {
        $sql = "UPDATE sheep SET sheepLongitude = :sheepLongitude,
            sheepLatitude = :sheepLatitude WHERE sheepID = :sheepID"; 
        $params = array(
            ':sheepID' => $sheepID,
            ':sheepLongitude' => $sheepLongitude,
            ':sheepLatitude' => $sheepLatitude,
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        if ($result->errorCode()==0) {
            return TRUE;             
        }
        return FALSE; 
    }

    function checkSheepAcceptance($sheepID) {
        $sql = "SELECT accepted FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $values = $result->fetch(PDO::FETCH_BOTH);

        if ($values[0] == 1) {
            return TRUE;
        }
        return FALSE;
    }

    function confirmSheepAcceptance($sheepID) {
        $sql = "UPDATE sheep SET accepted = 1,
            tracking = 1 WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        if ($result->errorCode()==0) {
            return TRUE;             
        }
        return FALSE; 
    }
    
    function toggleSheepTracking($sheepID, $tracking) {
        
        $sql = "UPDATE sheep SET tracking = :tracking WHERE sheepID = :sheepID"; 
        $params = array(
            ':sheepID' => $sheepID,
            ':tracking' => $tracking
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        if ($result->errorCode()==0) {
            return TRUE;             
        }
        return FALSE; 
    }
    
    
    function getSheepLongitude($sheepID) {

        $sql = "SELECT sheepLongitude FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        return $result;
    }

    function getSheepLatitude($sheepID) {

        $sql = "SELECT sheepLatitude FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        return $result;
    }

    function getSheepName($sheepID) {

        $sql = "SELECT sheepName FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        return $result;
    }
    
    function getSheepMobile($sheepID) {

        $sql = "SELECT sheepMobile FROM sheep WHERE sheepID = :sheepID";
        $params = array(
            ':sheepID' => $sheepID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);

        return $result;
    }


    function getAllSheepFromFlockID($flockID){
        $sql = "SELECT * FROM sheep WHERE flockID = :flockID";
        $params = array(
            ':flockID' => $flockID
        );
        $result = $this->dbh->prepare($sql);
        $result->execute($params);
        $values = $result->fetch(PDO::FETCH_BOTH);

        $allSheepInFlock = array();
        $counter = 0;

        foreach ($values as $sheep){
            $newSheep = new Sheep (
                $sheep[0], // sheepID
                $sheep[1], // sheepMobile
                $sheep[2], // sheepName
                $sheep[3], // sheepLongtitude
                $sheep[4], // sheepLatitude
                $sheep[5], // accepted
                $sheep[6], // tracking
                $sheep[7], // isShepherd
                $sheep[8] // flockID
            );
            $allSheepInFlock[$counter++] = $newSheep;
        }
        return $allSheepInFlock;
    }
}