<?php
namespace Tests\Mocks;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepositoryMock implements TransactionRepositoryInterface
{
    const MOCK = [
        'payer' => 1,
        'payee' => 2,
        'value' => 5
    ];

    public function getAllTransactions(){
        
    }

    public function getTransactionById(int $id){

    }
    
    public function createTransaction(array $transaction){
        $transactionInstance = new Transaction($transaction);
        $transactionInstance->id = 1;
        return $transactionInstance;
    }
}