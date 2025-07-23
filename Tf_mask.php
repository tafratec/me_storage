<?php

class Tf_mask
{
    /*
    public function __construct()
    {
        //Do nothing        
    }
    */
    public function generate_mask()
    {
              
        return $this->mixer();
        
    }

    public function pass ($num)
    {
        return $this->chkPrime($this->resolve($num));

    }
    private function mixer()
    {
        //9 digits based with 2 digits locator and 5 digits prime
        $final='xxxxxxxxx';        
        
        $locator = $this->nonRepeatedRand(1,6);
        $final[0]= $locator[0];
        $final[1]= $locator[1];
        $final[$locator[0]+1] = $this->getRand(0,9);
        $final[$locator[1]+1] = $this->getRand(0,9);

        $prime = $this->getPrime();
        
        $i=0;
        for ($x = 2; $x <= 8; $x++) 
        {
            if (($x<>$locator[0]+1) and ($x<>$locator[1]+1))
            {
                $final[$x] = $prime[$i];
                $i++;  
            }
        }
              
        return $final;

    }
    
    private function nonRepeatedRand($min,$max)
    {
       $first = $this->getRand($min,$max);       
       $second = $this->getRand($min,$max);
       while ($second===$first)
       {
        $second = $this->getRand($min,$max);
       }
       
       return $first.$second;  
    }
    private function getRand($min,$max)
    {
        
        return (rand($min,$max));
    }

    private function getPrime()
    {
        $prime1 = gmp_nextprime($this->getRand(10000,90000)); // next prime number greater than 10
        //$prime2 = gmp_nextprime(-1000); // next prime number greater than -1000
        return gmp_strval($prime1);

        /*
        echo 'Prim  ='.gmp_strval($prime1) . "\n";
        echo '<br>'; 
        echo 'Is it prim = '.$this->chkPrime($prime1);  
        echo '<br>'; 
        */    
        
    }
    
    private function resolve($num)
    {
        $final='xxxxxxx';
        $resolved ='yyyyy';
        $location1 = $num[0]-1;
        $location2 = $num[1]-1;
        
        //Remove locator
        $i=0;
        for ($x = 2; $x <= 8; $x++) 
        {
          $final[$i] = $num[$x];
          $i++;
        }
        
        //Shift

        $i=0;
        for ($x = 0; $x <= 6; $x++) 
        {
            if (($x<>$location1) and ($x<>$location2))
            {
                $resolved[$i] = $final[$x];
                $i++;  
            }
        }

        return $resolved;

    }

    private function chkPrime($num)
    {
        $result = gmp_prob_prime($num);
        
        if ($result==2)
        {
            return true;
        } 
        else
        {
            return false;
        }
    }

}