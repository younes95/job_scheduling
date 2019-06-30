<?php

class Structure{

    protected $items;

    public function __construct(){
      // Initialize the structure
      $this->items = array();
    }

    /** Add job and dependency to a structure */
    public function add($job,$dependency = null){
      $this->items[$job] = $dependency;
    }

    /** Get a job's dependency*/
    public function getDependency($job){
      if(array_key_exists($job,$this->items) === false) return false;
      
      return $this->items[$job] ;
    }

    /** Get all items */
    public function getItems(){
      return $this->items;
    }

    /** Check the structure if it has no dependency */
    public function hasNoDependency(){
      if(!array_filter($this->items)) return true;
      return false;
    }

    /** Return the size of the structure  */
    public function count(){
      return count($this->items);
    }


}

?>