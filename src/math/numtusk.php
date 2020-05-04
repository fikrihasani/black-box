<?php

namespace TuskerBrain\Math\NumTusk;

use Exception;

function dot_product(array $arr1, array $arr2): float
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

function cosine_similarity(array $arr1, array $arr2): float
{
    if (!is_array($arr1) || !is_array($arr2)) {
        throw new Exception("Error: Input not an Array. found: " . gettype($arr1) . " and " . gettype($arr2));
    }
    $arr1 = is_array($arr1[0]) ? $arr1 : [$arr1];
    $arr2 = is_array($arr2[0]) ? $arr2 : [$arr2];
    if (count($arr1) > 1 || count($arr2) > 1) {
        throw new Exception("Error: Input is a matrix not a vector");
    }
    $el1 = 0;
    $el2 = 0;
    foreach ($arr1[0] as $key => $value) {
        $el1 += pow($value, 2);
    }
    foreach ($arr2[0] as $key => $value) {
        $el2 += pow($value, 2);
    }
    $res = $this->dot_product($arr1[0], $arr2[0]) / (sqrt($el1) * sqrt($el2));
    return $res;
}

function cosine_distance(array $arr1, array $arr2): float
{
    if (!is_array($arr1) || !is_array($arr2)) {
        # code...
        throw new Exception("Error: Input not an Array. found: " . gettype($arr1) . " and " . gettype($arr2));
    }
    return 1 - $this->cosine_similarity($arr1, $arr2);
}

function euclidian_distance(array $arr1, array $arr2): float
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
function sigmoid($x): float
{
    return 1 / (1 + exp(-$x));
}

function relu($x, $a = 0): float
{
    return max($a, $x);
}

function tanh($x)
{
    return (exp($x) - exp(-$x)) / (exp($x) + exp(-$x));
    // or just call build in php tanh function 
}
