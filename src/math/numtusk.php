<?php

namespace TuskerBrain\Math;

use Exception;

/** PHP implementation for everything related to mathematical function as a base**/
class NumTusk
{
    /** dot product**/
    public function dot_product(array $arr1, array $arr2): float
    {
        if ((count($arr1) == count($arr2)) == false) {
            # code...
            throw new Exception("Error: array size missmatch - arr1: " . count($arr1) . ", arr2: " . count($arr2));
        }
        $product = 0;
        foreach ($arr1 as $key => $value) {
            # code...
            $product += ($arr1[$key] * $arr2[$key]);
        }
        return $product;
    }

    public function cosine_similarity(array $arr1, array $arr2): float
    {
        if (!is_array($arr1) || !is_array($arr2)) {
            # code...
            throw new Exception("Error: Input not an Array. found: " . gettype($arr1) . " and " . gettype($arr2));
        }

        $el1 = 0;
        $el2 = 0;
        foreach ($arr1 as $key => $value) {
            # code...
            $el1 += pow($arr1[$key], 2);
            $el2 += pow($arr2[$key], 2);
        }

        $res = $this->dot_product($arr1, $arr2) / (sqrt($el1) + sqrt($el2));
        return $res;
    }

    public function cosine_distance(array $arr1, array $arr2): float
    {
        if (!is_array($arr1) || !is_array($arr2)) {
            # code...
            throw new Exception("Error: Input not an Array. found: " . gettype($arr1) . " and " . gettype($arr2));
        }
        return 1 - $this->cosine_similarity($arr1, $arr2);
    }

    public function euclidian_distance(array $arr1, array $arr2): float
    {
        if (!is_array($arr1) || !is_array($arr2)) {
            # code...
            throw new Exception("Error: Input not an Array. found: " . gettype($arr1) . " and " . gettype($arr2));
        }

        $res = 0;
        foreach ($arr1 as $key => $value) {
            # code...
            $res += pow(($arr1[$key] - $arr2[$key]), 2);
        }

        return sqrt($res);
    }

    /*
        below is the functions needed to compute activatio function for NN and several ML aplications
    */
    public function sigmoid($x): float
    {
        return 1 / (1 + exp(-$x));
    }

    public function relu($x, $a = 0): float
    {
        return max($a, $x);
    }

    public function tanh($x)
    {
        return (exp($x) - exp(-$x)) / (exp($x) + exp(-$x));
        // or just call build in php tanh function 
    }
}
