<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 19/09/2018
 * Time: 20:09
 */

namespace DoubleCheck\Services;


use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;



class ProjectService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    private $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator,
        Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
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


        //enviar email
        //disparar notificação date('Y-m-d H:i:s')
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

    public function createFile(array $data){
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));

    }

}