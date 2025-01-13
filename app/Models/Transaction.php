<?php

namespace App\Models;

use App\Entities\TransactionEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'operation_type',
        'amount',
        'related_user_id',
        'exchange_rate',
        'comment',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * По дате
     * @param $query
     * @param $dateFrom
     * @param $dateTo
     * @return mixed
     */
    public function scopeFilterByDate($query, $dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $query->whereDate(TransactionEntity::CREATED_AT, '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate(TransactionEntity::CREATED_AT, '<=', $dateTo);
        }

        return $query;
    }

    public function scopeSort($query, $sortBy = 'created_at', $sortDirection = 'desc')
    {
        $validSortBy = ['amount', 'created_at'];
        $validSortDirection = ['asc', 'desc'];

        if (in_array($sortBy, $validSortBy) && in_array($sortDirection, $validSortDirection)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query;
    }
}
