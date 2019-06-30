<?php

use PHPUnit\Framework\TestCase;

require_once "ReadingList.php";
require_once "Sequence.php";
require_once "Structure.php";
require_once "JobScheduling.php";

final class JobSchedulingTest extends TestCase
{

    /** @test */
    public function that_we_can_pass_the_challenge_0(){
      
      $structure = new Structure();

      $jobScheduling = new JobScheduling();

      $sequence = $jobScheduling->calculate($structure);

      $this->assertEmpty($sequence->getItems());
      
    }

    /** @test */
    public function that_we_can_pass_the_challenge_1(){

        $structure = new Structure();

        $jobScheduling = new JobScheduling();

        $structure->add("a");

        $sequence = $jobScheduling->calculate($structure);
        
        $this->assertContains("a", $sequence->getItems());

        $this->assertEquals(1, count($sequence->getItems()));
        
    }

    /** @test */
    public function that_we_can_pass_the_challenge_2(){

      $structure = new Structure();

        $jobScheduling = new JobScheduling();

        $structure->add("a");
        $structure->add("b");
        $structure->add("c");
      /***** A revoir */
        $array1 = $jobScheduling->calculate($structure);
        $array2 = $jobScheduling->calculate($structure);

        $this->assertEqualsCanonicalizing($array1, $array2);
      
    }

    /** @test */
    public function that_we_can_pass_the_challenge_3(){
     
        $structure = new Structure();

        $jobScheduling = new JobScheduling();

        $structure->add("a");
        $structure->add("b","c");
        $structure->add("c");
      /***** A revoir */
        $sequence = $jobScheduling->calculate($structure);

        // Assert that c come before b
        $this->assertGreaterThan(array_search("b", $sequence->getItems()),array_search("c", $sequence->getItems()));

    }

    /** @test */
    public function that_we_can_pass_the_challenge_4(){

        $structure = new Structure();

        $jobScheduling = new JobScheduling();
        
        $structure->add("a");
        $structure->add("b","c");
        $structure->add("c","f");
        $structure->add("d","a");
        $structure->add("e","b");
        $structure->add("f");
        
        $sequence = $jobScheduling->calculate($structure);

        // f before c

        $this->assertGreaterThan(array_search("c", $sequence->getItems()),array_search("f", $sequence->getItems()));
        
        // c before b

        $this->assertGreaterThan(array_search("b", $sequence->getItems()),array_search("c", $sequence->getItems()));
        
        // b before e 

        $this->assertGreaterThan(array_search("e", $sequence->getItems()),array_search("b", $sequence->getItems()));

        // a before d

        $this->assertGreaterThan(array_search("d", $sequence->getItems()),array_search("a", $sequence->getItems()));
      
    }

    /** @test */
    public function that_we_can_pass_the_challenge_5(){

        $structure = new Structure();

        $jobScheduling = new JobScheduling();
        
        $structure->add("a");
        $structure->add("b");
        $structure->add("c","c");

        $sequence = $jobScheduling->calculate($structure);
      
        $this->assertArrayHasKey("error",$sequence);

        $this->assertEquals("Error : jobs can’t depend on themselves",$sequence["error"]);
    }

    /** @test */
    public function that_we_can_pass_the_challenge_6(){

      $structure = new Structure();

        $jobScheduling = new JobScheduling();
        
        $structure->add("a");
        $structure->add("b","c");
        $structure->add("c","f");
        $structure->add("d","a");
        $structure->add("e");
        $structure->add("f","b");

        $sequence = $jobScheduling->calculate($structure);
      
      $this->assertArrayHasKey("error",$sequence);

      $this->assertEquals("Error : jobs can’t have circular dependencies",$sequence["error"]);
 
    }
}



