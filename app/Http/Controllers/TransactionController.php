<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use App\Http\Requests\CreateTransaction;
use App\Http\Resources\ResourceResponse;
use App\Jobs\NotificationJob;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return ResourceResponse::getInstance($transactions)
            ->response()
            ->setStatusCode($transactions['status']);
    }

    public function store(CreateTransaction $request)
    {
        DB::beginTransaction();
        try {
            $transaction = $this->transactionService->makeTransaction($request->all());
            if ($transaction['status'] != 201) {
                throw new \Exception($transaction['errorMessage'], $transaction['status']);
            }
            DB::commit();

            return ResourceResponse::getInstance($transaction)
                ->response()
                ->setStatusCode($transaction['status']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResourceResponse::getInstance([
                'status' => $th->getCode(), 'errorMessage' => $th->getMessage()
            ])
                ->response()
                ->setStatusCode($th->getCode());
        }
    }

    public function show($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);

        return ResourceResponse::getInstance($transaction)
            ->response()
            ->setStatusCode($transaction['status']);
    }
}
