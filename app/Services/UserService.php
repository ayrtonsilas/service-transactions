<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\WalletServiceInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $walletService;

    public function __construct(UserRepositoryInterface $userRepository, WalletServiceInterface $walletService)
    {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
    }

    /**
     * Get all users
     * @return array
     */
    public function getAllUsers()
    {
        try {
            $users = $this->userRepository->getAllUsers();
            return ['status' => 200, 'result' => $users];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array
     */
    public function getUserById(int $id)
    {
        try {
            $user = $this->userRepository->getUserById($id);
            return ['status' => 200, 'result' => $user];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Get user by email or register_code
     * @param string $email
     * @param string $registerCode
     * @return array
     */
    public function getUserByFilter(string $email, string $registerCode)
    {
        try {
            $user = $this->userRepository->getUserByFilter($email, $registerCode);
            return ['status' => 200, 'result' => $user];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Create new User
     * @param array $userData
     * @return array 
     */
    public function makeUser(array $userData)
    {
        try {
            $user = $this->userRepository->getUserByFilter($userData['email'], $userData['register_code']);

            if (!empty($user)) {
                return ['status' => 400, 'errorMessage' => 'User already exists'];
            }

            $user = $this->userRepository->createUser($userData);
            if(empty($user->id)){
                throw new \Exception("User Processing Error");
            }
            
            $walletData = $this->walletService->makeWallet([
                'user' => $user->id,
                'amount' => $userData['amount'],
            ]);

            if($walletData['status'] != 201){
                throw new \Exception($walletData['errorMessage']);
            }

            return ['status' => 201, 'result' => $user];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * Update one User
     * @param int $id
     * @param arrray $userData
     * @return json response
     */
    public function updateUser(int $id, array $userData)
    {

        try {
            $user = $this->userRepository->getuserById($id);
            if (empty($user)) {
                return ['status' => 400, 'errorMessage' => 'User not exists'];
            }

            $this->userRepository->updateUser($user, $userData);
            return ['status' => 200, 'result' => 'User Updated'];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

    /**
     * check if the user is payer
     * @param int $id
     * @return array response
     */
    public function canSendValue(int $id)
    {
        try {
            $user = $this->userRepository->getuserById($id);
            if (empty($user)) {
                return ['status' => 400, 'errorMessage' => 'User not exists'];
            }
            $canReceive = $user->type == 'user';
            return ['status' => 200, 'result' => $canReceive];
        } catch (\Throwable $th) {
            return ['status' => 500, 'errorMessage' => $th->getMessage()];
        }
    }

}
