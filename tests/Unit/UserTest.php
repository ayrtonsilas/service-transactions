<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Services\WalletService;
use Tests\Mocks\UserRepositoryMock;
use Tests\Mocks\WalletRepositoryMock;

class UserTest extends TestCase
{


    /**
     * Test for create new user
     *
     * @return void
     */
    public function testNewUser()
    {
        // (new RepositoryServiceProvider(app()))->register();

        $walletService = new WalletService(new WalletRepositoryMock());
        $userService = new UserService(new UserRepositoryMock(), $walletService);

        $instanceService = $userService->makeUser(UserRepositoryMock::MOCK);

        $this->assertEquals(201, $instanceService['status']);
        $this->assertEquals(1, $instanceService['result']->id);
    }
}
