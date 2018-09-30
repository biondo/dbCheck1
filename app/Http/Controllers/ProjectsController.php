<?php

namespace DoubleCheck\Http\Controllers;

use DoubleCheck\Services\ProjectService;
use Illuminate\Http\Request;

use DoubleCheck\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use DoubleCheck\Http\Requests\ProjectCreateRequest;
use DoubleCheck\Http\Requests\ProjectUpdateRequest;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Validators\ProjectValidator;

/**
 * Class ProjectsController.
 *
 * @package namespace DoubleCheck\Http\Controllers;
 */
class ProjectsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectService
     */
    protected $service;

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service=$service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Só retorna os projetos relacionados ao usuario logado.
        return $this->repository->findWhere(['owner_id' => auth()->user()->getAuthIdentifier()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectCreateRequest $request)
    {
            return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return [
                'message' => 'Access denied!',
                'status' => false
            ];
        }
        return $this->repository->find($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        if ($this->checkProjectPermissions($id) == false)
        {
            return [
                'message' => 'Access denied!',
                'status' => false
            ];
        }
       return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return [
                'message' => 'Access denied!',
                'status' => false
            ];
        }
        return $this->repository->delete($id);
    }

    public function delete($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return [
                'message' => 'Access denied!',
                'status' => false
            ];
        }
        return $this->repository->del($id);
    }



    private function CheckProjectOwner($projectId)
    {
        $userId = auth()->user()->getAuthIdentifier();
        return $this->repository->isOwner($projectId, $userId);
    }

    private function CheckProjectMember($projectId)
    {
        $userId = auth()->user()->getAuthIdentifier();;
        return $this->repository->hasMember($projectId, $userId);
    }

    /**
     * @param $projectId
     * @return bool
     */
    private function CheckProjectPermissions($projectId)
    {
        if ($this->CheckProjectOwner($projectId) or $this->CheckProjectMember($projectId)) {
            return true;
        }
        return false;
    }

}
