<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 19/09/2018
 * Time: 20:09
 */

namespace DoubleCheck\Services;


use Carbon\Carbon;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Validators\ProjectValidator;
use Intervention\Image\ImageManager;
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

    public function __construct(
        ProjectRepository $repository,
        ProjectValidator $validator,
        Filesystem $filesystem,
        Storage $storage
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
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
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }


    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data); //salva objeto no banco
        $current = Carbon::now()->format('YmdHs'); //pega data e hora atual.
        $fileNameStore = "ARC" . '_' . $projectFile->id . '_' . $current . "." . $data['extension']; //cria nome do arquivo
        $this->storage->put($fileNameStore, $this->filesystem->get($data['file']));
        $this->storage->put('/thumbnail/'.$fileNameStore, $this->filesystem->get($data['file']));


        //$this->storage->put($fileNameStore, $this->filesystem->get('storage/profile_images/thumbnail/'));

        //Upload File
        //$request->file('profile_image')->storeAs('public/profile_images', $filenametostore);
        // $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $filenametostore);

/*
        if ($data['extension'] == 'jpg' || $data['extension'] == 'jpeg') {
            $thumbnailPath = public_path('storage/app/thumbnail/' . $fileNameStore);
            // create an image manager instance with favored driver
            $manager = new ImageManager(array('driver' => 'imagick'));
            // to finally create image instances
            $image = $manager->make($thumbnailPath)->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($thumbnailPath);
            echo ($data['extension']);
        }
*/
    }

}