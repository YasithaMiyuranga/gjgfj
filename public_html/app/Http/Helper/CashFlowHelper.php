<?php
namespace App\Http\Helper;

use App\Models\CashFlow;

class CashFlowHelper
{
    /**
     * Create a new CashFlow record in the database
     *
     * This function takes in the values for the CashFlow record and creates a new
     * record in the database.
     *
     * @param string $name The name of the CashFlow record
     * @param float $amount The amount of the CashFlow record
     * @param string $date The date of the CashFlow record
     * @param int $ref_id The ID of the reference record
     * @param string $ref_name The name of the reference record
     * @param string $incomeOrExpense Whether the record is an income or expense. Defaults to 'INCOME'
     * @return true if the record was created, false otherwise
     */
    public static function create($name, $amount, $date, $ref_id, $ref_name, $incomeOrExpense = 'INCOME')
    {
        $is_income = FALSE;
        $is_expense = FALSE;

        ($incomeOrExpense === 'INCOME') ? $is_income = TRUE : $is_expense = TRUE;

        $savedCashFlow = CashFlow::create([
            'name' => $name,
            'amount' => $amount,
            'date' => $date,
            'ref_id' => $ref_id,
            'ref_name' => $ref_name,
            'is_income' => $is_income,
            'is_expense' => $is_expense
        ]);

        if ($savedCashFlow) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Delete a CashFlow record from the database
     *
     * @return boolean TRUE if the record was deleted, FALSE otherwise
     */
    public static function delete($ref_id, $ref_name)
    {
        if ($ref_id != null || $ref_name != null) {
            CashFlow::where('ref_id', $ref_id)->where('ref_name', $ref_name)->delete();
            return TRUE;
        }
       return FALSE;

    }

    /**
     * Update a CashFlow record in the database
     *
     * This function takes in the new values for the CashFlow record and updates the
     * corresponding record in the database.
     *
     * @param string $name The name of the CashFlow record
     * @param float $amount The amount of the CashFlow record
     * @param string $date The date of the CashFlow record
     * @param int $ref_id The ID of the reference record
     * @param string $ref_name The name of the reference record
     * @param string $incomeOrExpense Whether the record is an income or expense. Defaults to 'INCOME'
     * @return true if the record was updated, false otherwise
     */
    public static function update($name, $amount, $date, $ref_id, $ref_name, $incomeOrExpense = 'INCOME')
    {
        $is_income = FALSE;
        $is_expense = FALSE;

        ($incomeOrExpense === 'INCOME') ? $is_income = TRUE : $is_expense = TRUE;

        // Update the record in the database
        $updatedCashFlow = CashFlow::where('ref_id', $ref_id)->where('ref_name', $ref_name)->update([
            'name' => $name,
            'amount' => $amount,
            'date' => $date,
            'is_income' => $is_income,
            'is_expense' => $is_expense
        ]);

        if ($updatedCashFlow) {
            return TRUE;
        }
        return FALSE;

    }

    /**
     * Find a CashFlow record in the database by its reference ID and table name
     *
     * @param int $id The ID of the reference record
     * @param string $tableName The name of the reference record table
     * @return Model|null The CashFlow record if found, null otherwise
     */
    public static function find($id, $tableName)
    {
        return CashFlow::where('ref_id', $id)
            ->where('ref_name', $tableName)
            ->first();
    }

}
