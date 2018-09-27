<?php

namespace DoubleCheck\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Project.
 *
 * @package namespace DoubleCheck\Entities;
 */
class Project extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];

    public function notes(){
        return $this->hasMany(ProjectNote::class);
    }

    public function members(){
        return $this->belongsToMany(User::class,
            'project_members',
            'project_id',
            'member_id');
    }

    public function files(){
        return $this->hasMany(ProjectFile::class); //faz o relacionamento com a tabela files
    }

}
