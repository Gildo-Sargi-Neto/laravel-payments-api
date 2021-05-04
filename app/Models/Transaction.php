<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payer_wallet_id', 'payee_wallet_id', 'description','value'
    ];

    /**
     * Relationship with payer's wallet
     */
    public function payer()
    {
        return $this->belongsTo(Wallet::class, 'payer_wallet_id', 'id');
    }

    /**
     * Relationship with payee's wallet
     */
    public function payee()
    {
        return $this->belongsTo(Wallet::class, 'payee_wallet_id', 'id');
    }
}
