<?php

namespace App\Http\Services\Operations;

use App\Http\Interfaces\MatrixCalculatorInterface;
use App\Http\Services\MatrixCalculatorService;
use App\Rules\CompatibleForMultiplication;

class MatrixMultiplyService extends MatrixCalculatorService implements MatrixCalculatorInterface
{
    /**
     * @param $matrices
     */
    public function setMatrices($matrices)
    {
        $this->matrices = $matrices;

        return $this;
    }

    /**
     * Validate Matrix Multiplication Request
     * The request matrices must be with the same sizes to perform multiply operation
     *
     * @return $this
     */
    public function validate(): void
    {
        request()->validate([
            'matrices' => ['array', new CompatibleForMultiplication()],
        ]);
    }


    /**
     * Multiply Matrices
     *
     * @param array $result
     * @param int $nextIndex
     * @return array
     */
    public function calculate(array $result = [], int $nextIndex = 1): array
    {
        if (count($result) == 0) {
            $firstMatrix = $this->matrices[0];
            $secondMatrix = $this->matrices[1];
        } else {
            if (isset($this->matrices[$nextIndex])) {
                $firstMatrix = $result;
                $secondMatrix = $this->matrices[$nextIndex];
                $result = [];
            }

        }
        for ($i = 0; $i < count($firstMatrix); $i++) {
            for ($j = 0; $j < count($secondMatrix[0]); $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < count($secondMatrix); $k++) {
                    $result[$i][$j] += $firstMatrix[$i][$k] * $secondMatrix[$k][$j];
                }
            }
        }

        $nextIndex++;

        if (count($this->matrices) != $nextIndex) {
            $result = $this->calculate($result, $nextIndex);
        }


        return $result;
    }
}
