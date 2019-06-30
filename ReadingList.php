<?php

class ReadingList
{
    protected $stack;
    protected $limit;
    
    public function __construct($limit = 10) {
        // initialize the stack
        $this->stack = array();
        // stack can only contain this many items
        $this->limit = $limit;
    }

    /** Get all items */
    public function getItems(){
      return $this->stack;
    }

    /** Add an item at the top of the stack */
    public function push($item) {
     
      if(array_search($item,$this->stack) === false){
      
        // trap for stack overflow
        if (count($this->stack) < $this->limit) {
            // prepend item to the start of the array
            array_unshift($this->stack, $item);
        } else {
            throw new RunTimeException('Stack is full!'); 
        }
      }
    }

    /** Get the item at the top of the stack */
    public function pop() {
        if ($this->isEmpty()) {
            // trap for stack underflow
	      throw new RunTimeException('Stack is empty!');
	  } else {
            // pop item from the start of the array
            return array_shift($this->stack);
        }
    }

    /** Check if the stack is empty */
    public function isEmpty() {
        return empty($this->stack);
    }

    /** Remove an item from the stack */
    public function remove($item){
      array_splice($this->stack,  array_search($item,$this->stack), 1); 
    }

    /** Print the stack */
    public function show(){

      $numItems = count($this->stack);
      $i = 0;

      foreach($this->stack as $element) {
        if(++$i === $numItems) echo $element;
        else echo $element, '<-';
      }
    }

    /** Check if an item exist in the stack */
    public function exist($item){
      return in_array($item,$this->stack);
    }

    /** Add before an element in the stack */
    public function addBefore($job,$dependency){

      array_splice( $this->stack, array_search($dependency,$this->stack)+1, 0, $job );
          
    } 
}