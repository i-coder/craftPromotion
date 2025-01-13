<?php

namespace App\Entities;

class UserBalanceEntity
{
    public const USER_ID = 'user_id';
    public const BALANCE = 'balance';
    public const DEPOSITY = 'deposit';
    public const TRANSFER = 'transfer';
    public const DEFAULT_BALANCE = 0;
    public const RUB = "RUB";

    public static function all(): array
    {
        return [
            self::USER_ID,
            self::BALANCE,
            self::DEPOSITY,
            self::DEFAULT_BALANCE,
            self::TRANSFER,
            self::RUB,
        ];
    }
}
