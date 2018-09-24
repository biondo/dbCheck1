<?php

namespace DoubleCheck\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProjectNoteValidator.
 *
 * @package namespace DoubleCheck\Validators;
 */
class ProjectNoteValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'project_id'=>'required|integer',
            'title'=>'required',
            'note'=>'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
