<?php
/**
 * Created by PhpStorm.
 * User: Biondo
 * Date: 22/09/2018
 * Time: 01:35
 */

namespace DoubleCheck\Validators;


use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    protected $rules = [
        'email'=>'required|E-mail',
        'password'=>'required'

    ];
}