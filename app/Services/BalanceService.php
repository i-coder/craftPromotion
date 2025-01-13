<?php

namespace App\Services;

use App\Dto\BalanceDto;
use App\Dto\DataDtoInterface;
use App\Dto\DepositDto;
use App\Dto\TransactionDto;
use App\Dto\TransferDto;
use App\Dto\WithdrawDto;
use App\Models\Transaction;
use App\Entities\TransactionEntity;
use App\Entities\UserBalanceEntity;
use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BalanceService
{
    /**
     * @var CurrencyService
     */
    private CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }


    /**
     * Пополнение баланса
     * @param DepositDto $dto
     * @return void
     */
    public function deposit(DepositDto $dto): void
    {
        DB::transaction(function () use ($dto) {
            $balance = $this->getOrCreateUserBalance($dto->userId);
            $this->updateBalance($balance, $dto->amount);

            // Можно конечно использовать queue
            \Illuminate\Support\defer(function () use ($dto) {
                $this->createTransaction(UserBalanceEntity::DEPOSITY, $dto);
            });
        });
    }

    /**
     * Снятие средств
     * @param WithdrawDto $dto
     * @return void
     */
    public function withdraw(WithdrawDto $dto): void
    {
        DB::transaction(function () use ($dto) {
            $balance = $this->getUserBalanceOrFail($dto->userId);

            if ($balance->balance < $dto->amount) {
                throw new \Exception('Недостаточно средств для снятия.');
            }

            $this->updateBalance($balance, -$dto->amount);
            $this->createTransaction(TransactionEntity::WITHDRAW, $dto);
        });
    }

    /**
     * Перевод средств
     * @param TransferDto $dto
     * @return void
     */
    public function transfer(TransferDto $dto): void
    {
        DB::transaction(function () use ($dto) {
            $fromBalance = $this->getUserBalanceOrFail($dto->fromUserId);
            $toBalance = $this->getOrCreateUserBalance($dto->toUserId);

            if ($fromBalance->balance < $dto->amount) {
                throw new \Exception('Недостаточно средств для перевода.');
            }

            $this->updateBalance($fromBalance, -$dto->amount);
            $this->updateBalance($toBalance, $dto->amount);
            $this->createTransaction(UserBalanceEntity::TRANSFER, $dto);
        });
    }

    /**
     * Баланс пользователя
     * @param BalanceDto $dto
     * @return array
     * @throws \Exception
     */
    public function getBalance(BalanceDto $dto): array
    {
        $balance = $this->getUserBalanceOrFail($dto->userId);
        $amount = $balance->balance;

        if ($dto->currency && $dto->currency !== UserBalanceEntity::RUB) {
            $amount = $this->currencyService->convertAmount($amount, $dto->currency);
        }

        return [
            'balance' => $amount,
            'currency' => $dto->currency ?? UserBalanceEntity::RUB,
        ];
    }

    /**
     * Транзакций пользователя по фильтру
     * @param TransactionDto $dto
     * @return mixed
     */
    public function getTransactions(TransactionDto $dto)
    {
        return Transaction::where(TransactionEntity::USER_ID, $dto->userId)
            ->filterByDate($dto->dateFrom ?? null, $dto->dateTo ?? null)
            ->sort($dto->sortBy ?? TransactionEntity::CREATED_AT, $dto->sortDirection ?? TransactionEntity::SORT_DESC)
            ->paginate($dto->perPage);
    }

    /**
     * Создание транзакции
     * @param string $operationType
     * @param DataDtoInterface $dto
     * @return void
     */
    private function createTransaction(string $operationType, DataDtoInterface $dto): void
    {
        $data = [
            TransactionEntity::USER_ID => isset($dto->userId) ? $dto->userId : $dto->fromUserId,
            TransactionEntity::AMOUNT => $dto->amount,
            TransactionEntity::OPERATION_TYPE => $operationType,
            TransactionEntity::COMMENT => $dto->comment,
        ];

        if (isset($dto->toUserId)) {
            $data[TransactionEntity::RELATED_USER_ID] = $dto->toUserId;
        }

        try {
            Transaction::create($data);
        } catch (\Exception $e) {
            throw new \Exception("Ошибка создании транзакции", 422);
        }
    }


    /**
     * Получить или создать баланс пользователя
     * @param int $userId
     * @return UserBalance
     */
    private function getOrCreateUserBalance(int $userId): UserBalance
    {
        return UserBalance::firstOrCreate(
            [UserBalanceEntity::USER_ID => $userId],
            [UserBalanceEntity::BALANCE => UserBalanceEntity::DEFAULT_BALANCE]
        );
    }

    /**
     * Получить баланс пользователя
     * @param int $userId
     * @return UserBalance
     * @throws NotFoundHttpException
     */
    private function getUserBalanceOrFail(int $userId): UserBalance
    {
        $balance = UserBalance::where(UserBalanceEntity::USER_ID, $userId)->first();

        if (!$balance) {
            throw new NotFoundHttpException("Баланс для пользователя с ID {$userId} не найден.");
        }

        return $balance;
    }

    /**
     * Обновление баланса пользователя
     * @param UserBalance $balance
     * @param float $amount
     * @return void
     */
    private function updateBalance(UserBalance $balance, float $amount): void
    {
        $balance->balance += $amount;
        $balance->save();
    }

}
