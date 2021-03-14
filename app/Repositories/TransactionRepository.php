<?php

namespace App\Repositories;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Models\Transaction;


class TransactionRepository implements TransactionRepositoryInterface
{

    protected $entity;

    public function __construct(Transaction $transaction)
    {
        $this->entity = $transaction;
    }

    /**
     * Get all Transactions
     * @return array
     */
    public function getAllTransactions()
    {
        return $this->entity->paginate();
    }

    /**
     * Get Transaction by ID
     * @param int $id
     * @return object
     */
    public function getTransactionById(int $id)
    {
        return $this->entity->find($id);
    }

    /**
     * Create new Transaction
     * @param array $transaction
     * @return object
     */
    public function createTransaction(array $transaction)
    {
        return $this->entity->create($transaction);
    }
}