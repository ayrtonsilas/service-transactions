<?php

namespace Tests\Mocks;

use App\Models\Wallet;
use App\Repositories\Contracts\WalletRepositoryInterface;

class WalletRepositoryMock implements WalletRepositoryInterface
{
    const MOCK = [
        'user' => 1,
        'amount' => 10
    ];

    public function getWalletByUser(int $id)
    {
        return new Wallet(WalletRepositoryMock::MOCK);
    }
    
    public function createWallet(array $wallet)
    {
        return new Wallet($wallet);
    }

    public function updateWallet(object $wallet, array $walletData)
    {
    }
}
