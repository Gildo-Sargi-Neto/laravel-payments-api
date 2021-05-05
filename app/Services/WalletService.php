<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\WalletRepository;
use App\Services\Responses\ServiceResponse;

class WalletService
{
    /** @var WalletRepository */
    protected $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Creates a new wallet
     * @param array $params
     *
     * @return ServiceResponse
     */
    public function create(array $params): ServiceResponse
    {
        DB::beginTransaction();
        try {
            $wallet = $this->walletRepository->create($params);
        } catch (Exception $e) {
            DB::rollback();
            return new ServiceResponse(false, 'Error creating wallet!', $e->getMessage());
        }
        DB::commit();
        return new ServiceResponse(true, 'Wallet created successfully!', $wallet);
    }
}
