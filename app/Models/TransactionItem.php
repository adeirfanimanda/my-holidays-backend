<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'users_id',
        'tours_id',
        'transactions_id',
        'quantity',
    ];

    public function tours()
    {
        return $this->hasOne(Tours::class, 'id', 'tours_id');
    }
}
