<?php

namespace App\Services;

use App\Commons\OperationEnum;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\WalletServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    protected $transactionRepository;
    protected $walletService;
    protected $userService;
    protected $notificationService;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        WalletServiceInterface $walletService,
        UserServiceInterface $userService,
        NotificationServiceInterface $notificationService
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletService = $walletService;
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }

    /**
     * Get all transactions
     * @return array
     */
    public function getAllTransactions()
    {
        try {
            $transactions = $this->transactionRepository->getAllTransactions();
            return ['status' => 200, 'result' => $transactions];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Get Transaction by ID
     * @param int $id
     * @return array
     */
    public function getTransactionById(int $id)
    {
        try {
            $transaction = $this->transactionRepository->getTransactionById($id);
            return ['status' => 200, 'result' => $transaction];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Create new Transaction
     * @param array $transactionData
     * @return array 
     */
    public function makeTransaction(array $transactionData)
    {
        try {
            if ($transactionData['payer'] == $transactionData['payee']) {
                return ['status' => 400, 'errorMessage' => 'Payer must be different from Payee'];
            }

            $wallet = $this->walletService->getWalletByUser($transactionData['payer']);
            $canSendValue = $this->userService->canSendValue($transactionData['payer']);

            if (
                !isset($wallet['result']) ||
                ($wallet['result']['amount'] < $transactionData['value'])
            ) {
                return ['status' => 400, 'errorMessage' => 'User without amount'];
            }
            if (!isset($canSendValue['result']) || $canSendValue['result'] !== true) {
                return ['status' => 400, 'errorMessage' => 'User is a shopkeeper'];
            }

            $debit = $this->walletService->updateWallet(
                $transactionData['payer'],
                $transactionData['value'],
                OperationEnum::DEBIT
            );
            $credit = $this->walletService->updateWallet(
                $transactionData['payee'],
                $transactionData['value'],
                OperationEnum::CREDIT
            );

            if ($debit['status'] != 200 || $credit['status'] != 200) {
                return ['status' => 400, 'errorMessage' => 'Inconsistent Transaction'];
            }

            $transaction = $this->transactionRepository->createTransaction($transactionData);
            if (empty($transaction->id)) {
                throw new \Exception("Error Processing Transaction");
            }

            $notification = $this->notificationService->makeNotification([
                'reference_type' => 'transaction',
                'reference_value' => $transaction->id,
                'message' => [
                    'from' => $transaction->payer,
                    'to' => $transaction->payee,
                    'messsage' => 'transaction received'
                ]
            ]);

            if($notification['status'] != 201){
                throw new \Exception($notification['errorMessage'], $notification['status']);
                
            }

            return ['status' => 201, 'result' => $transaction];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }
}
