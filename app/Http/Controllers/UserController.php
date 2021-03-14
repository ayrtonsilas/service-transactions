<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\CreateUser;
use App\Http\Resources\ResourceResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $usersData = $this->userService->getAllUsers();

        return ResourceResponse::getInstance($usersData)
            ->response()
            ->setStatusCode($usersData['status']);
    }

    public function store(CreateUser $request)
    {
        DB::beginTransaction();
        try {
            $userData = $this->userService->makeUser($request->all());
            if ($userData['status'] != 201) {
                throw new \Exception($userData['errorMessage'], $userData['status']);
            }
            DB::commit();

            return ResourceResponse::getInstance($userData)
                ->response()
                ->setStatusCode($userData['status']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResourceResponse::getInstance([
                'status' => $th->getCode(), 'errorMessage' => $th->getMessage()
            ])
                ->response()
                ->setStatusCode($th->getCode());
        }
    }

    public function show($id)
    {
        $userData = $this->userService->getUserById($id);

        return ResourceResponse::getInstance($userData)
            ->response()
            ->setStatusCode($userData['status']);
    }

    public function update(CreateUser $request, $id)
    {
        $userData = $this->userService->updateUser($id, $request->all());

        return ResourceResponse::getInstance($userData)
            ->response()
            ->setStatusCode($userData['status']);
    }
}
