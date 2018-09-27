<?php

namespace DoubleCheck\Http\Controllers;

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
     * @var ProjectValidator
     */
    protected $validator;

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
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
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProjectCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $project = $this->repository->create($request->all());

            $response = [
                'message' => 'Project created.',
                'data'    => $project->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        if($this->checkProjectPermissions($id) == false)
        {
            return ['message' => 'Access denied!',
            'status' => false];
        }
        return $this->repository->find($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->repository->find($id);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $project = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Project updated.',
                'data'    => $project->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
       if($this->checkProjectPermissions($id) == false) {
           return [
               'message' => 'Access denied!',
               'status' => false
           ];
       }
           return $this->repository->delete($id);


    }

    private function CheckProjectOwner($projectId){
        $userId = auth()->user()->getAuthIdentifier();
        return $this->repository->isOwner($projectId, $userId);
    }

    private function CheckProjectMember($projectId){
        $userId = auth()->user()->getAuthIdentifier();;
        return $this->repository->hasMember($projectId, $userId);
    }

    /**
     * @param $projectId
     * @return bool
     */
    private function CheckProjectPermissions($projectId){
        if ($this->CheckProjectOwner($projectId) or $this->CheckProjectMember($projectId)) {
            return true;
        }
        return false;
    }

}
