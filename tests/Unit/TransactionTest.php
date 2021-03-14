<?php

namespace Tests\Unit;

use App\Services\NotificationService;
use App\Services\TransactionService;
use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Services\WalletService;
use Tests\Mocks\NotificationJobMock;
use Tests\Mocks\NotificationRepositoryMock;
use Tests\Mocks\TransactionRepositoryMock;
use Tests\Mocks\UserRepositoryMock;
use Tests\Mocks\WalletRepositoryMock;

class TransactionTest extends TestCase
{


    /**
     * Test for create new transaction
     *
     * @return void
     */
    public function testNewTransaction()
    {

        $walletService = new WalletService(new WalletRepositoryMock);
        $userService = new UserService(new UserRepositoryMock, $walletService);
        $notificationService = new NotificationService(new NotificationRepositoryMock, new NotificationJobMock);
        $transactionService = new TransactionService(new TransactionRepositoryMock, $walletService, $userService, $notificationService);

        $response = $transactionService->makeTransaction(TransactionRepositoryMock::MOCK);

        $this->assertEquals(201, $response['status']);
        $this->assertEquals(1, $response['result']->id);
    }
}
