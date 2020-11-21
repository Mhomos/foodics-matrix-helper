<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MatrixCalculatorService
{
    /**
     * Allowed Operations
     */
    const OPERATIONS = ['multiply'];

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var mixed
     */
    protected $matrices;
    /**
     * @var
     */
    protected $result;
    /**
     * @var mixed
     */
    private $operation;

    /**
     * General Validation on the Entered Matrices
     * @rule operation required must be valid operation
     * @rule matrices is an array and must be at least two array to perform the operation
     * @rule matrices must contains numeric number to perform the operation
     * @return $this
     */
    public function validateRequest(): MatrixCalculatorService
    {
        request()->validate([
            'operation' => ['required', Rule::in(self::OPERATIONS)],
            'matrices' => ['array', 'min:2'],
            'matrices.*.*.*' => ['numeric'],
        ]);

        $this->setOperation();

        return $this;
    }

    /**
     * Apply the Operation
     *
     * @return mixed
     */
    public function initOperation(): MatrixCalculatorService
    {
        $operationService = resolve(sprintf('App\\Http\\Services\\Operations\\Matrix%sService',
            Str::ucfirst($this->operation)));

        $operationService->validate();

        $this->result = $operationService->setMatrices(request('matrices'))->calculate();

        return $this;
    }

    /**
     * Get the final operation result
     *
     * @param string $vieType
     * @return mixed
     */
    public function getResult($vieType = 'excel'): array
    {
        $this->formatResult();

        return (array)$this->result;
    }

    /**
     * Set the operation which will be applied
     *
     * @return void
     */
    private function setOperation(): void
    {
        $this->operation = request('operation');
    }

    /**
     * Format the result to Excel Sheet view
     */
    private function formatResult()
    {
        $matrixLength = count($this->result[0]);

        $columns = $this->createColumnsByMatrixLength($matrixLength);

        $result = [];
        for ($i = 0; $i < count($this->result); $i++) {
            for ($j = 0; $j < count($this->result[$i]); $j++) {
                $result[$i + 1][$columns[$j]] = $this->result[$i][$j];
            }
        }

        $this->result = $result;
    }

    /**
     * Generate the Columns by Matrix Length
     *
     * @param $length
     * @param string $firstLetters
     * @return array
     */
    private function createColumnsByMatrixLength($length, $firstLetters = '')
    {
        $columns = array();
        $letters = range('A', 'Z');

        // Iterate over 26 letters.
        foreach ($letters as $letter) {
            // Paste the $firstLetters before the next.
            $column = $firstLetters . $letter;

            // Add the column to the final array.
            $columns[] = $column;

            // If it was the end column that was added, return the columns.
            if (count($columns) == $length) {
                return $columns;
            }
        }

        // Add the column children.
        foreach ($columns as $column) {
            // Stop iterating if you've reached the maximum character length.
            if (count($columns) < $length) {
                $new_length = $length - 26;
                $new_columns = $this->createColumnsByMatrixLength($new_length, $column);
                // Merge the new columns which were created with the final columns array.
                $columns = array_merge($columns, $new_columns);
            }
        }

        return $columns;
    }

}
