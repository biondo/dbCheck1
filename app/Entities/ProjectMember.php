<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 22/09/2018
 * Time: 23:08
 */

namespace DoubleCheck\Entities;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectMember extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'project_id',
        'member_id',
    ];

    // public function project(){
    //   return $this->belongsTo(Project::class); //faz o relacionamento com a tabela project
    //}

}