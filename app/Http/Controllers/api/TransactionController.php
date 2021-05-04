<?php

namespace App\Http\Controllers\api;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\CreateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    public function __construct(
        TransactionService $transactionService
    ) {
        $this->transactionService = $transactionService;
    }

    /**
     * Creates a transaction
     * POST /api/transaction
     *
     * @param CreateTransactionRequest $request
     * @return JsonResponse
     */
    public function create(CreateTransactionRequest $request): JsonResponse
    {
        $params = [
            'payer_wallet_id' => $request->payer_wallet_id,
            'payee_wallet_id' => $request->payee_wallet_id,
            'description' => $request->description ?: null,
            'value' => $request->value,
        ];

        $createTransactionResponse = $this->transactionService->create($params);

        if ($createTransactionResponse->success) {
            $client = new Client();
            $request = $client->post('http://o4d9z.mocklab.io/notify');
        }

        return response()->json($createTransactionResponse);
    }
}
