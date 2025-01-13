<?php

namespace Tests\Unit;

use App\Services\BalanceService;
use App\Services\CurrencyService;
use App\Dto\DepositDto;
use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class BalanceServiceTest extends TestCase
{
    public function testDeposit(): void
    {
        $currencyServiceMock = Mockery::mock(CurrencyService::class);

        $balanceService = Mockery::mock(BalanceService::class, [$currencyServiceMock])
            ->makePartial();

        $balanceService
            ->shouldReceive('updateBalance')
            ->once();

        $balanceService
            ->shouldReceive('createTransaction')
            ->withAnyArgs()
            ->once();

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($callback) {
                $callback();
            });

        $depositDto = new DepositDto(
            userId: 1,
            amount: 500,
            comment: 'Тестовое пополнение баланса'
        );

        $balanceService->deposit($depositDto);
    }
}
