<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBalance extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_balances';
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'balance', 'currency'];

    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
