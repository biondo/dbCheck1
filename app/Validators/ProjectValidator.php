<?php

namespace DoubleCheck\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProjectValidator.
 *
 * @package namespace DoubleCheck\Validators;
 */
class ProjectValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'owner_id'=>'required|Integer',
            'client_id'=>'required|Integer',
            'name'=>'required',
            'progress'=>'required',
            'status'=>'required',
            'due_date'=>'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
