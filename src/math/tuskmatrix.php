<?php

namespace TuskerBrain\Math;

use Exception;

/** PHP implementation for matrix and matrix operations**/
class TuskMatrix
{
    public function is_row_array(array $arr): bool
    {
        return count($arr) === 1;
    }

    public function transpose(array $arr): array
    {
        $trans = [];

        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr[0]); $j++) {
                $trans[$j][$i] = $arr[$i][$j];
            }
        }
        return $trans;
    }

    public function init_values($rows, $cols = 1, $values = null): array
    {
        $arr = [];

        foreach (range(0, $cols - 1) as $col) {
            foreach (range(0, $rows - 1) as $row) {
                $arr[$row][$col] = isset($values) ? $values : rand();
            }
        }


        return $arr;
    }

    private function get_row(array $arr, int $index): array
    {
        return $arr[$index];
    }

    private function get_col(array $arr, int $index): array
    {
        $col = [];
        if (!is_array($arr[0])) {
            throw new Exception("Error: array not a 2D matrix");
        }
        return array_column($arr, $index);
    }

    /** append arr to matrix. interface to array_push **/
    public function append(array $arr1, array $arr2): array
    {
        array_push($arr1, $arr2);
        return $arr1;
    }


    public function get_size(array $arr): array
    {
        return array("row" => $this->get_row_size($arr), "col" => $this->get_col_size($arr));
    }

    public function get_col_size(array $arr): int
    {
        return count($arr[0]);
    }

    public function get_row_size(array $arr): int
    {
        return count($arr);
    }

    /** perform array operations**/
    public function add(array $array, $var): array
    {
        $arr = [];
        $array = is_array($array[0]) ? $array : [$array];
        if (is_array($var)) {
            $var = is_array($var[0]) ? $var : [$var];
            if ($this->get_size($array) === $this->get_size($var)) {
                for ($i = 0; $i < count($var); $i++) {
                    for ($j = 0; $j < count($var[0]); $j++) {
                        $arr[$i][$j] = $array[$i][$j] + $var[$i][$j];
                    }
                }
            } else {
                throw new Exception("Error: array doesnt have identical size");
            }
        } else {
            for ($i = 0; $i < count($array); $i++) {
                for ($j = 0; $j < count($array[0]); $j++) {
                    $arr[$i][$j] = $array[$i][$j] + $var;
                }
            }
        }
        return $arr;
    }

    public function is_matrix(array $array): bool
    {
        return ((is_array($array[0]) && is_array($array[1]) && (count($array[0]) === count($array[1]))));
    }

    public function substraction(array $arr, $var): array
    {
        $arr_res = [];
        $arr = is_array($arr[0]) ? $arr : [$arr];
        if (is_array($var)) {
            $var = is_array($var[0]) ? $var : [$var];
            if ($this->get_size($arr) === $this->get_size($var)) {
                for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($arr[0]); $j++) {
                        $arr_res[$i][$j] = $arr[$i][$j] - $var[$i][$j];
                    }
                }
            } else {
                throw new Exception("Error: array doesnt have identical size");
            }
        } else {
            for ($i = 0; $i < count($arr); $i++) {
                for ($j = 0; $j < count($arr); $j++) {
                    $arr_res[$i][$j] = $arr[$i][$j] - $var;
                }
            }
        }
        return $arr_res;
    }

    public function multiply(array $arr, $var): array
    {
        $product = [];
        $arr = is_array($arr[0]) ? $arr : [$arr];
        if (is_array($var)) {
            $dp = new NumTusk();
            $var = is_array($var[0]) ? $var : [$var];
            if ($this->is_row_array($var)) {
                $var = $this->transpose($var);
            }

            if ($this->get_col_size($arr) != $this->get_row_size($var)) {
                throw new Exception("Error: Array size invalid for multiplication", 1);
            }
            $product = $this->init_values($this->get_row_size($arr), $this->get_col_size($var));
            foreach ($product as $key => $value) {
                for ($j = 0; $j < count($value); $j++) {
                    // dot product between row and col
                    $product[$key][$j] = $dp->dot_product($arr[$key], $this->get_col($var, $j));
                }
            }
        } else {
            if (!$this->is_row_array($arr) && !$this->is_matrix($var)) {
                throw new Exception("Error: array size invalid");
            }
            for ($i = 0; $i < count($arr); $i++) {
                for ($j = 0; $j < count($arr[0]); $j++) {
                    $product[$i][$j] = $arr[$i][$j] * $var;
                }
            }
        }
        return $product;
    }
}
