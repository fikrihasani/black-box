<?php

namespace TuskerBrain\Math;

use Exception;

/** PHP implementation for matrix and matrix operations**/
class TuskMatrix
{
    public function is_row_array(array $arr): bool
    {
        return is_array($arr[0]);
    }

    public function transpose(array $arr): array
    {
        $trans = [];

        if ($this->is_row_array($arr)) {
            for ($i = 0; $i < count($arr); $i++) {
                # code...
                $trans[$i] = [$arr[$i]];
            }
        } else {
            for ($i = 0; $i < count($arr); $i++) {
                # code...
                for ($j = 0; $j < count($arr[0]); $j++) {
                    # code...
                    $trans[$j][$i] = $arr[$i][$j];
                }
            }
        }
        return $trans;
    }

    public function init_values($size, $rows = null, $values = 0): array
    {
        $arr = array_fill(0, $size, 0);
        if (!is_null($rows)) {
            foreach ($arr as $key => $value) {
                $arr[$key] = array_fill(0, $rows, 0);
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
        return array($this->get_row_size($arr), $this->get_col_size($arr));
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
        if (is_array($var)) {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $arr[$i][$j] = $array[$i][$j] + $var[$i][$j];
                }
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
        if (is_array($var)) {
            if ($this->is_matrix($var)) {
                for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($arr[0]); $j++) {
                        $arr_res[$i][$j] = $arr[$i][$j] - $var[$i][$j];
                    }
                }
            } else {
                foreach ($arr as $key => $value) {
                    # code...
                    $arr_res[$key] = $value - $var[$key];
                }
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
        if (is_array($var)) {
            if (!is_array($var[0])) {
                $var = $this->transpose($var);
            }
            if ($this->row != count($var[0])) {
                throw new Exception("Error: array size missmatch");
            }

            $dp = new NumTusk();
            $product = $this->init_values($this->row, count($var[0]));
            foreach ($product as $key => $value) {
                for ($j = 0; $j < count($value); $j++) {
                    // dot product between row and col
                    $product[$key][$j] = $dp->dot_product($arr[$key], $this->get_col($var, $j));
                }
            }
        } else {
            for ($i = 0; $i < count($arr); $i++) {
                for ($j = 0; $j < count($arr[0]); $j++) {
                    $product[$i][$j] = $arr[$i][$j] * $var;
                }
            }
        }
        return $product;
    }
}
