<?php

namespace App\Entities;

class TransactionEntity
{
    public const USER_ID = 'user_id';
    public const AMOUNT = 'amount';
    public const OPERATION_TYPE = 'operation_type';
    public const COMMENT = 'comment';
    public const RELATED_USER_ID = 'related_user_id';
    public const WITHDRAW = 'withdraw';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const SORT_DESC = 'desc';

    public static function all(): array
    {
        return [
            self::USER_ID,
            self::AMOUNT,
            self::OPERATION_TYPE,
            self::COMMENT,
        ];
    }
}
