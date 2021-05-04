<?php

namespace App\Services;

use Exception;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Services\Responses\ServiceResponse;

class UserService
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
        WalletService $walletService
    ) {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
    }

    /**
     * Creates a new user
     * @param array $params
     *
     * @return ServiceResponse
     */
    public function create(array $params): ServiceResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($params);

            $params = [
                'user_id' => $user->id,
            ];

            $walletServiceResponse = $this->walletService->create($params);

            if (!$walletServiceResponse->success) {
                DB::rollback();
                return $walletServiceResponse;
            }
        } catch (Exception $e) {
            DB::rollback();
            return new ServiceResponse(false, 'Error creating user!', compact($e));
        }
        DB::commit();
        return new ServiceResponse(true, 'User created successfully!', $user);
    }
}
