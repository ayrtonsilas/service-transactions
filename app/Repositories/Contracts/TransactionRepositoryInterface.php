<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryInterface
{
    public function getAllTransactions();
    public function getTransactionById(int $id);
    public function createTransaction(array $transaction);
}