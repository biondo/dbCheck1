<?php

namespace DoubleCheck\Http\Controllers;

use Illuminate\Http\Request;
use DoubleCheck\Entities\ProjectNote;

use DoubleCheck\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use DoubleCheck\Http\Requests\ProjectNoteCreateRequest;
use DoubleCheck\Http\Requests\ProjectNoteUpdateRequest;
use DoubleCheck\Repositories\ProjectNoteRepository;
use DoubleCheck\Validators\ProjectNoteValidator;

/**
 * Class ProjectNotesController.
 *
 * @package namespace DoubleCheck\Http\Controllers;
 */
class ProjectNotesController extends Controller
{
    /**
     * @var ProjectNoteRepository
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;

    /**
     * ProjectNotesController constructor.
     *
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteValidator $validator
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $projectNotes = $this->repository->findWhere(['project_id' => $id]);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projectNotes,
            ]);
        }

        return $projectNotes;
            //view('projectNotes.index', compact('projectNotes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectNoteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProjectNoteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $projectNote = $this->repository->create($request->all());

            $response = [
                'message' => 'ProjectNote created.',
                'data'    => $projectNote->toArray(),
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
     * @param $noteId
     * @return \Illuminate\Http\Response
     */
    public function show($id, $noteId)
    {
        $projectNote = $this->repository->findWhere(['project_id'=> $id, 'id' => $noteId]);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projectNote,
            ]);
        }

        return $projectNote;
            //view('projectNotes.show', compact('projectNote'));
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
        $projectNote = $this->repository->find($id);

        return view('projectNotes.edit', compact('projectNote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectNoteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProjectNoteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $projectNote = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProjectNote updated.',
                'data'    => $projectNote->toArray(),
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
    public function destroy($id, $noteId)
    {
        $deleted = $this->repository->delete($noteId);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ProjectNote deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProjectNote deleted.');
        //return $this->repository->delete($noteId);
    }
}
