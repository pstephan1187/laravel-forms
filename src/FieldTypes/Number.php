<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Number extends Field
{
	protected $rules = 'numeric';
	protected $input_type = 'number';
}