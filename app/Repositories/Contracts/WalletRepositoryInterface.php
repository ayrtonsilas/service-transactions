<?php

namespace App\Repositories\Contracts;

interface WalletRepositoryInterface
{
    public function getWalletByUser(int $id);
    public function createWallet(array $wallet);
    public function updateWallet(object $wallet, array $walletData);
}