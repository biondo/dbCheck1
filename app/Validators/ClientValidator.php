<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 22/09/2018
 * Time: 01:35
 */

namespace DoubleCheck\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
    protected $rules = [
        'name'=>'required|max:255',
        'responsible'=>'required|max:255',
        'email'=>'required|E-mail',
        'phone'=>'required',
        'address'=>'required',

    ];
}