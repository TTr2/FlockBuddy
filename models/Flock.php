<?php
require_once 'autoload.php';
/* 
 * FlockBuddy - the Android app to keep track of your flock.
 * HackMCR2015 - Tim Tyler, Steven Tomlinson, Mudit Pandya
 * 24/10/2015 - 25/10/2015
 */

/**
 * Flock object representing a flock of sheep and 1 shepherd.
 * @author Tim Tyler
 */
class Flock {
    
    protected $flockID;
    protected $flockName;
    protected $flockShepherdID;
    protected $flockStart;
    protected $flockEnd;
    protected $flockRadius;
    
    
    
    function __construct($flockID, $flockName, $flockShepherdID, $flockStart, 
            $flockEnd, $flockRadius) {
        $this->flockID = $flockID;   
        $this->flockName = $flockName; 
        $this->flockShepherdID = $flockShepherdID;
        $this->flockStart = $flockStart;
        $this->flockEnd = $flockEnd;
        $this->flockRadius = $flockRadius;        
    }
    
    public function getFlockID() {
        return $this->flockID;
    }

    public function getFlockName() {
        return $this->flockName;
    }

    public function getFlockSheperd() {
        return $this->flockSheperd;
    }

    public function getFlockStart() {
        return $this->flockStart;
    }

    public function getFlockEnd() {
        return $this->flockEnd;
    }

    public function getFlockRadius() {
        return $this->flockRadius;
    }

    public function setFlockID($flockID) {
        $this->flockID = $flockID;
    }

    public function setFlockName($flockName) {
        $this->flockName = $flockName;
    }

    public function setFlockSheperd($flockSheperd) {
        $this->flockSheperd = $flockSheperd;
    }

    public function setFlockStart($flockStart) {
        $this->flockStart = $flockStart;
    }

    public function setFlockEnd($flockEnd) {
        $this->flockEnd = $flockEnd;
    }

    public function setFlockRadius($flockRadius) {
        $this->flockRadius = $flockRadius;
    }


    
    
}
