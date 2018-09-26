<?php

namespace DoubleCheck\Http\Controllers;

use DoubleCheck\Entities\User;
use DoubleCheck\Repositories\ClientRepository;
use DoubleCheck\Repositories\UserRepository;
use DoubleCheck\Repositories\UserRepositoryEloquent;
use DoubleCheck\Services\ClientService;
use DoubleCheck\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package DoubleCheck\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientService
     */
    private $service;


    /**
     * UserController constructor.
     * @param UserRepository $repository
     * @param UserService $service
     */
    public function __construct(UserRepositoryEloquent $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
        //Client::create($request->all());
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
