<?php
/**
 * Created by PhpStorm.
 * User: biondo
 * Date: 26/09/18
 * Time: 17:09
 */

namespace DoubleCheck\Presenters;


use DoubleCheck\Transformers\ProjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ProjectTransformer();
    }
}