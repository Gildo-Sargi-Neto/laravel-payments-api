<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Repositories\TransactionRepository;
use App\Services\Responses\ServiceResponse;

class TransactionService
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Creates a new transaction
     * @param array $params
     *
     * @return ServiceResponse
     */
    public function create(array $params): ServiceResponse
    {
        DB::beginTransaction();
        try {
            $payerWallet = $this->walletRepository->find($params['payer_wallet_id']);
            $payeeWallet = $this->walletRepository->find($params['payee_wallet_id']);

            $client = new Client();
            $request = $client->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            if ($request->getStatusCode() !== 200) {
                DB::rollback();
                return new ServiceResponse(false, 'Unauthorized transaction!', compact($params));
            }
            if ($payerWallet->user->type === 'SHOPKEEPER') {
                DB::rollback();
                return new ServiceResponse(false, 'Shopkeepers cannot make transactions!', compact($params));
            }

            if ($payerWallet->balance < $params['value']) {
                DB::rollback();
                return new ServiceResponse(false, 'Insufficient balance in the wallet', compact($params));
            }
            $transaction = $this->transactionRepository->create($params);
            $payerWallet->decrement('balance', $params['value']);
            $payeeWallet->increment('balance', $params['value']);
        } catch (Exception $e) {
            DB::rollback();
            return new ServiceResponse(false, 'Error creating transaction!', $e->getMessage());
        }
        DB::commit();
        return new ServiceResponse(true, 'Transaction completed successfully!', $transaction);
    }
}
