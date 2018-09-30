<?php

namespace DoubleCheck\Http\Controllers;

use DoubleCheck\Repositories\ProjectFileRepository;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Services\ProjectService;
use Illuminate\Http\Request;


class ProjectFileController extends Controller
{
    /**
     * @var ProjectRepository
     */

    private $repository;
    /**
     * @var ProjectService
     */
    private $service;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $this->repository->all();
        return $this->repository->findWhere(['owner_id' => auth()->user()->getAuthIdentifier()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['project_id'] = $request->project_id;
        $this->service->createFile($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Acesso Negado!'];
        }
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->checkProjectOwner($id)==false){
            return ['error' => 'Acesso Negado!'];
        }
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->checkProjectOwner($id)==false){
            return ['error' => 'Acesso Negado!'];
        }
        $this->repository->find($id)->delete();
    }

    private function CheckProjectOwner($projectId){
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }

    private function CheckProjectMember($projectId){
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    private function CheckProjectPermissions($projectId){
        if ($this->CheckProjectOwner($projectId) or $this->CheckProjectMember($projectId)) {
                return true;
        }
        return false;
    }


}
