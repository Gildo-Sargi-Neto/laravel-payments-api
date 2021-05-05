<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A shopkeeper user cannot make transaction
     *
     * @return void
     */
    public function testShopkeeperCannotMakeTransaction()
    {
        $shopkeeperUser = factory(User::class)->state('withWallet')->create(['type' => 'SHOPKEEPER']);
        $commonUser = factory(User::class)->state('withWallet')->create(['type' => 'COMMON']);

        $params = [
            'payer_wallet_id' => $shopkeeperUser->wallet->id,
            'payee_wallet_id' => $commonUser->wallet->id,
            'value' => 10
        ];

        $transactionServiceResponse = app(TransactionService::class)->create($params);

        $shopkeeperUser->refresh();
        $commonUser->refresh();

        $this->assertFalse($transactionServiceResponse->success);
        $this->assertTrue($commonUser->wallet->balance === $shopkeeperUser->wallet->balance);
    }

    /**
     * A common user can make transaction to another common user
     *
     * @return void
     */
    public function testCommonUserCanMakeTransactionToCommonUser()
    {
        $commonUser1 = factory(User::class)->state('withWallet')->create(['type' => 'COMMON']);
        $commonUser2 = factory(User::class)->state('withWallet')->create(['type' => 'COMMON']);

        $params = [
            'payer_wallet_id' => $commonUser1->wallet->id,
            'payee_wallet_id' => $commonUser2->wallet->id,
            'value' => 10
        ];

        $transactionServiceResponse = app(TransactionService::class)->create($params);

        $commonUser1->refresh();
        $commonUser2->refresh();

        $this->assertTrue($transactionServiceResponse->success);
        $this->assertTrue($commonUser1->wallet->balance !== $commonUser2->wallet->balance);
    }

    /**
     * A common user can make transaction to a shopkeeper
     *
     * @return void
     */
    public function testCommonUserCanMakeTransactionToShopkeeer()
    {
        $commonUser = factory(User::class)->state('withWallet')->create(['type' => 'COMMON']);
        $shopkeeperUser = factory(User::class)->state('withWallet')->create(['type' => 'SHOPKEEPER']);

        $params = [
            'payer_wallet_id' => $commonUser->wallet->id,
            'payee_wallet_id' => $shopkeeperUser->wallet->id,
            'value' => 10
        ];

        $transactionServiceResponse = app(TransactionService::class)->create($params);

        $commonUser->refresh();
        $shopkeeperUser->refresh();

        $this->assertTrue($transactionServiceResponse->success);
        $this->assertTrue($commonUser->wallet->balance !== $shopkeeperUser->wallet->balance);
    }
}
