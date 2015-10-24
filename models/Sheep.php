<?php
require_once 'autoload.php';
/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Sheep object representing a sheep or a shepherd.
 * @author Tim Tyler
 */
class Sheep {

    protected $sheepID; // Composite - flockID + mobile    
    protected $flockID; // Foreign Key
    protected $sheepMobile; //44 7XXXXXXXX
    protected $sheepName; // String
    protected $sheepLongtitude; // Double
    protected $sheepLatitude; // Double
    protected $accepted; // Bool
    protected $tracking; // Bool
    protected $isShepherd; // Bool

    
    // Constructor - when used initially passes null values. For use by Tracker.
    function __construct($sheepID, $sheepMobile, $flockID, $sheepName, 
            $sheepLongtitude,$sheepLatitude, $accepted, $tracking, $isShepherd) 
    {     
        $this->sheepID = $sheepID;
        $this->sheepMobile = $sheepMobile;
        $this->flockID = $flockID;        
        $this->sheepName = $sheepName;
        $this->sheepLongtitude = $sheepLongtitude;
        $this->sheepLatitude = $sheepLatitude;
        $this->accepted = $accepted;
        $this->tracking = $tracking;
        $this->isShepherd = $isShepherd;
    }

    
    
    public function getSheepMobile() {
        return $this->sheepMobile;
    }

    public function getFlockID() {
        return $this->flockID;
    }

    public function getSheepID() {
        return $this->sheepID;
    }

    public function getSheepName() {
        return $this->sheepName;
    }

    public function getSheepLongtitude() {
        return $this->sheepLongtitude;
    }

    public function getSheepLatitude() {
        return $this->sheepLatitude;
    }

    public function getAccepted() {
        return $this->accepted;
    }

    public function getTracking() {
        return $this->tracking;
    }

    public function getIsShepherd() {
        return $this->isShepherd;
    }

    public function setSheepMobile($sheepMobile) {
        $this->sheepMobile = $sheepMobile;
    }

    public function setFlockID($flockID) {
        $this->flockID = $flockID;
    }

    public function setSheepID($sheepID) {
        $this->sheepID = $sheepID;
    }

    public function setSheepName($sheepName) {
        $this->sheepName = $sheepName;
    }

    public function setSheepLongtitude($sheepLongtitude) {
        $this->sheepLongtitude = $sheepLongtitude;
    }

    public function setSheepLatitude($sheepLatitude) {
        $this->sheepLatitude = $sheepLatitude;
    }

    public function setAccepted($accepted) {
        $this->accepted = $accepted;
    }

    public function setTracking($tracking) {
        $this->tracking = $tracking;
    }

    public function setIsShepherd($isShepherd) {
        $this->isShepherd = $isShepherd;
    }

        
    
/* FOR DATABASE RETRIEVAL?
  public function __construct($row_from_database){
       $this->id = $row_from_database->id;
       $this->name = $row_from_database->name;
       // etc.
   }
 */    
    
}
