<?php

namespace App\Services\Contracts;

interface TransactionServiceInterface
{
    public function getAllTransactions();
    public function getTransactionById(int $id);
    public function makeTransaction(array $transactionData);
}
