<?php

namespace App\Http\Controllers;

use App\Factories\DtoFactory;
use App\Http\Requests\BalanceRequest;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Services\BalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    private BalanceService $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Зачисление
     * @param DepositRequest $request
     * @return JsonResponse
     */
    public function deposit(DepositRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->balanceService->deposit(DtoFactory::createDepositDto(
            $request->validated()
        ));

        return response()->json(['message' => 'Средства зачислены.']);
    }

    /**
     * Списание
     * @param WithdrawRequest $request
     * @return JsonResponse
     */
    public function withdraw(WithdrawRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->balanceService->withdraw(DtoFactory::createWithdrawDto(
            $request->validated()
        ));

        return response()->json(['message' => 'Средства списаны.']);
    }

    // Перевод
    public function transfer(TransferRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->balanceService->transfer(DtoFactory::createTransferDto(
            $request->validated()
        ));

        return response()->json(['message' => 'Перевод выполнен.']);
    }

    /**
     * Получение баланса
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function balance(BalanceRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->balanceService->getBalance(DtoFactory::createBalanceDto(
            $request->validated()
        )));
    }

    public function transactions(TransactionRequest $request)
    {
        $transactions = $this->balanceService->getTransactions(
            DtoFactory::createTransactionDto($request->validated()),
        );

        return TransactionResource::collection($transactions);
        //return response()->json($transactions);
    }
}
