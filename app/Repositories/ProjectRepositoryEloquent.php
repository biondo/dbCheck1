<?php

namespace DoubleCheck\Repositories;

use DoubleCheck\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Entities\Project;
use DoubleCheck\Validators\ProjectValidator;

/**
 * Class ProjectRepositoryEloquent.
 *
 * @package namespace DoubleCheck\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProjectValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    //Função para desativar um projeto
    public function disable($projectId){
        $project = $this->find($projectId);
        $project->active = 0;
        $project->save();
    }

    public function isOwner($projectId, $userId){
        if (count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))){
            return true;
        }

        return false;
    }

    public function hasMember($projectId, $memberId){
        $project = $this->find($projectId);
        foreach($project->members as $member){
            if($member->id == $memberId){
                return true;
            }
        }
        return false;
    }

    public function presenter()
    {
        //return parent::presenter();
        return ProjectPresenter::class;
    }
    
}
