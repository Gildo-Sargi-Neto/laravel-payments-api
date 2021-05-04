<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship with wallet's payment transactions
     */
    public function payment()
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id', 'id');
    }

    /**
     * Relationship with wallet's receivement transactions
     */
    public function receivement()
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id', 'id');
    }
}
