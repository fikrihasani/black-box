<?php

namespace TuskerBrain\Math;

use Exception;
use TuskerBrain\Math\PhpNum;

/** PHP implementation for matrix and matrix operations**/
class PhpMatrix
{

    public array $matrix;
    public string $size;
    public int $row;
    public int $column;
    public int $sizeArea;

    public function __construct(array $list)
    {
        if (!is_array($list)) {
            # code...
            throw new Exception("Error: list is not an array");
        }
        $is_matrix = false;
        if (is_array($list[0])) {
            $list = [$list];
            $is_matrix = true;
        }
        $this->matrix = $list;
        $this->set_param(true, $is_matrix);
    }

    /* 
        set params. called every time array size changed like dot product or multiplications
    */
    private function set_param(bool $valid, bool $matrix): void
    {
        $this->row = count($this->matrix);
        $this->column = $matrix ? count($this->matrix[0]) : 1;
        $this->size = "rows: " . strval($this->row) . ", columns: " . strval($this->column);
        $this->sizeArea = $this->row * $this->column;
    }

    public function is_row_array(array $arr): bool
    {
        return is_array($arr[0]);
    }

    public function transpose(self $arr): self
    {
        $trans = [];
        for ($i = 0; $i < count($arr->matrix); $i++) {
            # code...
            for ($j = 0; $j < count($arr->matrix[0]); $j++) {
                # code...
                $trans[$j][$i] = $arr->matrix[$i][$j];
            }
        }
        return new self($trans);
    }

    public function init_zeros($size, $rows = null): self
    {
        $arr = array_fill(0, $size, 0);
        if (!is_null($rows)) {
            # code...
            foreach ($arr as $key => $value) {
                $arr[$key] = array_fill(0, $rows, 0);
            }
        }

        return new self($arr);
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
    public function append(array $arr): void
    {
        array_push($this->matrix, $arr);
    }

    /** perform array operations**/
    public function add($var): self
    {
        $arr = [];
        if (is_array($var)) {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $arr[$i][$j] = $this->matrix + $var[$i][$j];
                }
            }
        } else {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $arr[$i][$j] = $this->matrix + $var;
                }
            }
        }
        return new self($arr);
    }

    public function substraction($var): self
    {
        $arr = [];
        if (is_array($var)) {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $arr[$i][$j] = $this->matrix - $var[$i][$j];
                }
            }
        } else {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $arr[$i][$j] = $this->matrix - $var;
                }
            }
        }
        return new self($arr);
    }

    public function multiply($var): self
    {
        $product = [];
        if (is_array($var)) {
            if (!is_array($var[0])) {
                $var = $this->transpose(new self($var));
            }
            if ($this->row != count($var[0])) {
                throw new Exception("Error: array size missmatch");
            }

            $dp = new PhpNum();
            $product = $this->init_zeros($this->row, count($var[0]));
            foreach ($product as $key => $value) {
                for ($j = 0; $j < count($value); $j++) {
                    // dot product between row and col
                    $product->matrix[$key][$j] = $dp->dot_product($this->matrix[$key], $this->get_col($var, $j));
                }
            }
        } else {
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($var[0]); $j++) {
                    $product[$i][$j] = $this->matrix[$i][$j] * $var;
                }
            }
        }
        return new self($product);
    }
}
