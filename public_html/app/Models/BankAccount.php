<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'branch_name',
        'is_default',
    ];

    /**
     * Return the id of the default bank account.
     *
     * If no default bank account exists, returns the id of the first bank account.
     * If no bank accounts exist, returns null.
     *
     * @return int|null
     */
    public static function getDefaultBankAccountId()
    {
        $defaultBankAccount = self::where('is_default', true)->first();
        if(!$defaultBankAccount) {
            if(BankAccount::first()){
                return BankAccount::first()->id;
            }
            return null;
        }
        else{
            return $defaultBankAccount->id;
        }
    }
}
