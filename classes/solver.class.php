<?php

class Solver
{      
     
    const VERSION = '1.0';
    const DATE_APPROVED = '2017-08-26';       


    public function version()
    {

       printf("Solver ".VERSION);

    }

    public function solve($file, $separator)
    {

        $input = file($file);

        if (!$input) {

             throw new Exception('File missing.');

        }

        $k = 0;

        $cases = [];

        foreach ($input as $line) {

            if (is_numeric(trim($line))) {

                if (intval(trim($line)) > 0) $cases[] = [];

            } else {

                $cases[count($cases)-1][] = $this->parseLine(trim($line));

            }  
        }

        $str = "";

        foreach ($cases as $case) {

            $result = $this->solveCase($case);

            $str .= $result.$separator;

        }

        return $str;
        
    }
                    
    private function solveCase($case)
    {
        
        $x = $y = 0;

        foreach ($case as $path) {

            $x += $path["x"];

            $y += $path["y"];
   
        }
 
        $av_x = $x/count($case);

        $av_y = $y/count($case);

        $max_distance = 0;

        foreach ($case as $path) {

            $d = sqrt(($path["x"]-$av_x)*($path["x"]-$av_x)+($path["y"]-$av_y)*($path["y"]-$av_y));

            if ($d>$max_distance) $max_distance = $d;

        }
 
        return round($av_x,4)." ".round($av_y,4)." ".round($max_distance,5);
    }
    
    private function parseLine($str)
    {

        $arr = explode(" ",$str);

        $x0 = floatval($arr[0]);

        $y0 = floatval($arr[1]);

        array_splice($arr,0,2);

        $actions = [];

        while (count($arr) > 0) {

           $actions[] = [$arr[0],floatval($arr[1])];

           array_splice($arr,0,2);

        }
     
        while (count($actions) > 0) {

           if ($actions[0][0] == "start") {

               $alpha = intval($actions[0][1]);

           } else {

               $alpha += intval($actions[0][1]);
           }

           $d = $actions[1][1];

           $x0 += $d*cos(deg2rad($alpha));

           $y0 += $d*sin(deg2rad($alpha));

           array_splice($actions,0,2);

        }
          
        return ["x" => $x0, "y" => $y0];

    }
       
}