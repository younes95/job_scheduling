<?php

class Sequence{

    protected $items;
    protected $limit;

    public function __construct($limit = 10){
        // initialize the sequence
        $this->items = array();
        // queue can only contain this many items
        $this->limit = $limit;
    }

    /** Get all items */
    public function getItems(){
      return $this->items;
    }

    /** Get the first item that was inserted */
    public function pop() {
        if ($this->isEmpty()) {
          // trap for queue underflow
          throw new RunTimeException('Queue is empty!');
        } else {
          // pop item from the end of the array
          return array_pop($this->items);
        }
    }

    /** Add in item in the queue */
    public function push($item) {

      if(!array_search($item,$this->items)){
        // trap for queue overflow
        if (count($this->items) < $this->limit) {
          // prepend item to the start of the array
            array_unshift($this->items, $item);
        } else {
            throw new RunTimeException('Queue  is full!'); 
        }
      }
    }

    /** Check if the queue is empty */
    public function isEmpty() {
      return empty($this->items);
    }

    /** Print the queue */
    public function show(){

      $numItems = count($this->items);
      $i = 0;

      if($numItems != 0){
        foreach($this->items as $element) {
          if(++$i === $numItems) echo $element;
          else echo $element, '<-';
        }
        echo ' ( Right element is the first job to execute ) ';
      } else echo '[]';

    }

    /** Return the queue in a no significant order  */
    public function shuffle(){
      shuffle($this->items);
    }

    /** Check if an item exist in the queue */
    public function exist($item){
     return in_array($item,$this->items);
    }

    /** Merge the items in stack with the items in the queue */
    public function addFromStack($items){
      $this->items = array_merge(array_reverse($items),$this->items);
    }

}

?>