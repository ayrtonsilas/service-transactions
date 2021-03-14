<?php

namespace App\Services;

use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Services\Contracts\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    protected $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Get Wallet by User
     * @param int $id
     * @return array
     */
    public function getWalletByUser(int $id)
    {
        try {
            $wallet = $this->walletRepository->getWalletByUser($id);
            return ['status' => 200, 'result' => $wallet];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Create new Wallet
     * @param array $walletData
     * @return array 
     */
    public function makeWallet(array $walletData)
    {
        try {
            $wallet = $this->walletRepository->createWallet($walletData);
            return ['status' => 201, 'result' => $wallet];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Update one Wallet
     * @param int $idUser
     * @param float $value
     * @param string $operation debit|credit
     * @return array response
     */
    public function updateWallet(int $idUser, float $value, string $operation)
    {
        try {
            $wallet = $this->walletRepository->getWalletByUser($idUser);
            if (!$wallet) {
                return ['status' => 404, 'errorMessage' => 'Wallet Not Found'];
            }

            $amount = $wallet->amount;
            if ($operation == 'debit') {
                $amount -= $value;
            } else {
                $amount += $value;
            }
            if ($amount < 0) {
                return ['status' => 400, 'errorMessage' => 'Inconsistent Transaction'];
            }

            $this->walletRepository->updateWallet($wallet, ['amount' => $amount]);
            return ['status' => 200, 'errorMessage' => 'Wallet Updated'];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }
}
