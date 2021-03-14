<?php

namespace App\Repositories;

use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Models\Wallet;


class WalletRepository implements WalletRepositoryInterface
{

    protected $entity;

    public function __construct(Wallet $wallet)
    {
        $this->entity = $wallet;
    }
    /**
     * Get Wallet by ID User
     * @param int $id
     * @return object
     */
    public function getWalletByUser(int $id)
    {
        return $this->entity->where('user', $id)->first();
    }

    /**
     * Create new Wallet
     * @param array $wallet
     * @return object
     */
    public function createWallet(array $wallet)
    {
        return $this->entity->create($wallet);
    }

    /**
     * Update exists Wallet
     * @param object $wallet
     * @param array $walletData
     * @return object
     */
    public function updateWallet(object $wallet, array $walletData)
    {
        return $wallet->update($walletData);   
    }
}