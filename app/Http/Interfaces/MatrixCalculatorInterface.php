<?php

namespace App\Http\Interfaces;

use App\Http\Services\MatrixCalculatorService;

interface MatrixCalculatorInterface
{
    /**
     * Validate Matrix Multiplication Request
     * The request matrices must be with the same sizes to perform multiply operation
     *
     *
     */
    public function validate(): void;

    /**
     * Apply the Operation on Matrices
     *
     * @param array $result
     * @param int $nextIndex
     * @return array
     */
    public function calculate(array $result = [], int $nextIndex = 1): array;

}
