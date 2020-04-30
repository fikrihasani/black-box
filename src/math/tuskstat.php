<?php

namespace TuskerBrain\Math;

use Exception;
use TuskerBrain\Math\TuskMatrix;

class TuskStat
{
    /*
        return mean of array. if row matrix directly return the mean.
        if 2d matrix, perform axis wise mean. return row matrix 
    */
    public function mean(array $arr, int $axis = null)
    {
        // check if matrix
        if (!is_array($arr[0])) {
            return array_sum($arr) / count($arr);
        }

        $tmp = [];
        if (!is_null($axis)) {
            // perform columns wise operation
            if ($axis == 0) {
                foreach ($arr as $key => $value) {
                    $tmp[$key] = array_sum($arr[$key]) / count($arr[$key]);
                }
                return $tmp;
            }
            // perform columns wise operation
            elseif ($axis == 1) {
                $tm = new TuskMatrix();
                if (!$tm->is_matrix($arr)) {
                    # code...
                    throw new Exception("Error: Array isnt a valid matrix", 1);
                }
                foreach ($arr[0] as $key => $value) {
                    $columns = array_column($arr, $key);
                    $tmp[$key] = array_sum($columns) / count($columns);
                    # code...
                }
                return $tmp;
            } else {
                throw new Exception("Error: axis not recognized. Expected 0 or 1");
            }
        } else {
            // perform mean to all elements
            $tmp = [];
            foreach ($arr[0] as $key => $value) {
                $columns = array_column($arr, $key);
                $tmp[$key] = array_sum($columns) / count($columns);
            }
            return array_sum($tmp) / count($tmp);
        }
    }

    /*
        return most frequent value in array. 
    */
    public function modus(array $array)
    {
        $tmp = array_count_values($array);
        asort($tmp);
        $res = [];
        foreach ($tmp as $key => $value) {
            array_push($res, $key);
        }
        return $res[0];
    }

    /*
        return middle value in array
    */
    public function median(array $array)
    {
        asort($tmp);
        return $tmp[intval(count($tmp) / 2)];
    }

    // standard deviation

    // variance
}
