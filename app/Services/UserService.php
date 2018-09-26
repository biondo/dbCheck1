<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 22/09/2018
 * Time: 01:18
 */

namespace DoubleCheck\Services;


use DoubleCheck\Repositories\ClientRepository;
use DoubleCheck\Repositories\UserRepository;
use DoubleCheck\Repositories\UserRepositoryEloquent;
use DoubleCheck\Validators\ClientValidator;
use DoubleCheck\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService
{

    protected $repository;

    private $validator;

    public function __construct(UserRepositoryEloquent $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        try
        {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }
        catch (ValidatorException $e)
        {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }


        //enviar email (classe onde ficam as regras de negocio)
        //disparar notificação
    }

    public function update(array $data, $id)
    {
        try
        {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }
        catch (ValidatorException $e)
        {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
}