<?php

namespace TuskerBrain\Math;

use Exception;

use function TuskerBrain\Math\Numtusk\dot_product;
use function TuskerBrain\Math\Numtusk\euclidian_distance;

/** PHP implementation for matrix and matrix operations**/
class TuskMatrix
{
    public int $col;
    public int $row;
    public array $matrix;
    public array $shape;
    public function __construct(array $arr = null)
    {
        if (!isset($arr)) {
            # code...
            $this->matrix = [[]];
        }

        $this->matrix = is_array($arr[0]) ? $arr : [$arr];
        $this->init_param();
    }

    private function init_param()
    {
        $this->shape = $this->get_size();
        $this->row = count($this->matrix);
        $this->col = count($this->matrix[0]);
    }

    private function get_size(): array
    {
        return array(count($this->matrix), count($this->matrix[0]));
    }

    public function is_row_array(array $arr): bool
    {
        return count($arr) === 1;
    }

    public function transpose(array $arr): self
    {
        $trans = $this->init_zeros(count($arr[0]), count($arr));
        foreach (range(0, count($arr) - 1) as $i) {
            foreach (range(0, count($arr[0]) - 1) as $j) {
                $trans->matrix[$j][$i] = $arr[$i][$j];
            }
        }

        return $trans;
    }

    public function init_values($rows, $cols = 1, $values = null): self
    {
        $arr = [];

        foreach (range(0, $cols - 1) as $col) {
            foreach (range(0, $rows - 1) as $row) {
                $arr[$row][$col] = isset($values) ? $values : rand();
            }
        }


        return new self($arr);
    }

    //Init Matrix with zero value
    public function init_zeros($rows, $cols = 1): self
    {
        $arr = [];
        foreach (range(0, $cols - 1) as $col) {
            foreach (range(0, $rows - 1) as $row) {
                $arr[$row][$col] = 0;
            }
        }


        return new self($arr);
    }

    //Push array into matrix
    public function from_array(array $arr): self
    {

        return new self($arr);
    }

    private function get_row(int $index): self
    {
        return new self($this->matrix[$index]);
    }

    private function get_col(int $index): self
    {
        $col = [];
        return new self(array_column($this->matrix, $index));
    }

    /** append arr to matrix. interface to array_push **/
    public function append(array $arr)
    {
        array_push($this->matrix, $arr);
    }



    /** perform array operations**/
    public function add($var): self
    {
        $arr = [];
        if (is_array($var)) {
            $var = is_array($var[0]) ? $var : [$var];
            if ($this->get_size() === array(count($var), count($var[0]))) {
                foreach (range(0, count($var) - 1) as $i) {
                    foreach (range(0, count($var[0]) - 1) as $j) {
                        $arr[$i][$j] = $this->matrix[$i][$j] + $var[$i][$j];
                    }
                }
            } else {
                throw new Exception("Error: array doesnt have identical size");
            }
        } else {
            foreach (range(0, $this->row - 1) as $i) {
                foreach (range(0, $this->col - 1) as $j) {
                    $arr[$i][$j] = $this->matrix[$i][$j] + $var[$i][$j];
                }
            }
        }
        return new self($arr);
    }

    public function is_matrix(array $array): bool
    {
        return ((is_array($array[0]) && is_array($array[1]) && (count($array[0]) === count($array[1]))));
    }

    public function substraction($var): self
    {
        $arr_res = [];
        if (is_array($var)) {
            $var = is_array($var[0]) ? $var : [$var];
            if ($this->get_size() === array(count($var), count($var[0]))) {
                for ($i = 0; $i < $this->row; $i++) {
                    for ($j = 0; $j < $this->col; $j++) {
                        $arr_res[$i][$j] = $this->matrix[$i][$j] - $var[$i][$j];
                    }
                }
            } else {
                throw new Exception("Error: array doesnt have identical size");
            }
        } else {
            for ($i = 0; $i < $this->row; $i++) {
                for ($j = 0; $j < $this->col; $j++) {
                    $arr_res[$i][$j] = $this->matrix[$i][$j] - $var;
                }
            }
        }
        return new self($arr_res);
    }

    public function mul_scalar($var): self
    {
        $product = $this->init_zeros($this->row, $this->col);
        for ($i = 0; $i < count($this->row); $i++) {
            for ($j = 0; $j < count($this->col); $j++) {
                $product->matrix[$i][$j] = $this->matrix[$i][$j] * $var;
            }
        }
        return $product;
    }
    public function matmul(array $var, bool $element_wise = false): self
    {
        $product = [];
        $var = is_array($var[0]) ? $var : [$var];
        if ($this->col != count($var)) {
            print($this->col . " with " . count($var));
            throw new Exception("Error: Array size invalid for multiplication", 1);
        }

        if ($element_wise) {
            # code...
            foreach ($this->matrix as $key => $value) {
                for ($j = 0; $j < count($value); $j++) {
                    // dot product between row and col
                    $product[$key][$j] = $this->matrix[$key][$j] * $var[$key][$j];
                }
            }
        }
        $product = $this->init_zeros($this->row, count($var[0]));
        foreach ($product->matrix as $key => $value) {
            for ($j = 0; $j < count($value); $j++) {
                // dot product between row and col
                $product->matrix[$key][$j] = dot_product($this->matrix[$key], $this->get_col($j)->matrix);
            }
        }
        return $product;
    }
}
