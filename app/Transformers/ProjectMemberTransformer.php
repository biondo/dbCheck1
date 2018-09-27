<?php
/**
 * Created by PhpStorm.
 * User: biondo
 * Date: 26/09/18
 * Time: 16:55
 */

namespace DoubleCheck\Transformers;

use DoubleCheck\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
    public function transform(User $member){
        return [
            'member_id'=>$member->id,
            'name'=>$member->name,

        ];


    }
}