<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CompatibleForMultiplication implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param $matricesAttribute
     * @param $matricesValue
     * @return bool
     */
    public function passes($matricesAttribute, $matricesValue)
    {
        // Target Condition
        $firstMatrix = $matricesValue[0];
        $firstMatrixColumnCount = count($firstMatrix); // the column count in the first matrix

        // Remove First Matrix as Target
        array_shift($matricesValue);

        // the column count in the first matrix should be equal to the row count of the second matrix.
        foreach ($matricesValue as $index => $matrix) {
            $matrixRowsCount = count($matrix[0]);
            if ($firstMatrixColumnCount != $matrixRowsCount) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '(Incompatible) The Matrices need to be equal in sizes';
    }
}
