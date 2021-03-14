<?php

namespace App\Services\Contracts;

interface WalletServiceInterface
{
    public function getWalletByUser(int $id);
    public function makeWallet(array $walletData);
    public function updateWallet(int $idUser, float $value, string $operation);
}
