<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    //
    protected $table = 'debts';
    protected $fillable = [
        'value_debit',
        'value_discount',
        'parcel',
        'type_payment',
        'status_debit',
        'date_paid',
        'date_maturity',
        'observation',
        'banck_id',
        'provider_id',
        'card_id',
        'user_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);

    }
    public function card(){
        return $this->belongsTo(Card::class);
    }
    public function banck(){
        return $this->belongsTo(Bank::class);
    }

}
