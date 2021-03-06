<?php

namespace DoubleCheck\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use DoubleCheck\Repositories\ProjectNoteRepository;
use DoubleCheck\Entities\ProjectNote;
use DoubleCheck\Validators\ProjectNoteValidator;

/**
 * Class ProjectNoteRepositoryEloquent.
 *
 * @package namespace DoubleCheck\Repositories;
 */
class ProjectNoteRepositoryEloquent extends BaseRepository implements ProjectNoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectNote::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProjectNoteValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
