<?php
class JobScheduling{

  /**
   * Calculate the ordonnacement from a given structure
   * The index in the structure is the job and the dependency is it's value
   * If a job doesn't have a dependency the value is set to null
   */
  public function calculate($structure){

    $stack = new ReadingList(20);

    $sequence = new Sequence(20);

    $message = array();

    if($structure->hasNoDependency()){ 

      foreach($structure->getItems() as $key => $value){
        $sequence->push($key);
      }
      $sequence->shuffle();
    
    }else{
    
      foreach($structure->getItems() as $key => $value){
        $job = $key ; 
        $dependency = $value;
    
        if($dependency === null){
          $sequence->push($job);
          if($stack->exist($job) !== false) $stack->remove($job);
        }
    
        if($dependency !== null){
    
          
          switch (true) {
    
            case ($stack->exist($job) !== false && $stack->exist($dependency) !== false):
                $message["error"] = "Error : jobs can’t have circular dependencies";
                break;
    
            case ($job == $dependency):
                $message["error"] = "Error : jobs can’t depend on themselves";
                break;
    
            case ($sequence->exist($dependency) !== false && $structure->getDependency($dependency) === false):
                $sequence->push($job);
                break;
            
            case ($stack->exist($job) === false && $sequence->exist($dependency) !== false):
                $sequence->push($job);
                break;
    
            case ($stack->exist($job) === false && $stack->exist($dependency) !== false):
                $stack->addBefore($job,$dependency);
                break;
    
            case ($stack->exist($job) !== false && $stack->exist($dependency) === false):
                $stack->push($dependency);
                break;
            
            case ($stack->exist($job) === false && $stack->exist($dependency) === false):
                $stack->push($job);
                $stack->push($dependency);
                break;
          }
          
          
        } 
      }
      $sequence->addFromStack($stack->getItems());
      
    
    }
    
    if(array_key_exists("error",$message)) return $message;

    return $sequence;
    
  }
}

?>