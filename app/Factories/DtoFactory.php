<?php

namespace App\Factories;

use App\Dto\DepositDto;
use App\Dto\BalanceDto;
use App\Dto\TransactionDto;
use App\Dto\TransferDto;
use App\Dto\WithdrawDto;

class DtoFactory
{
    public static function createDepositDto(array $data): DepositDto
    {
        return DepositDto::fromArray($data);
    }

    /**
     * Создать DTO для списания
     */
    public static function createWithdrawDto(array $data): WithdrawDto
    {
        return WithdrawDto::fromArray($data);
    }

    public static function createTransferDto(array $data): TransferDto
    {
        return TransferDto::fromArray($data);
    }

    public static function createBalanceDto(array $data): BalanceDto
    {
        return BalanceDto::fromArray($data);
    }

    public static function createTransactionDto(array $data):TransactionDto
    {
        return TransactionDto::fromArray($data);
    }
}
