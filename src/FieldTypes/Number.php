<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Number extends Field
{
	protected $view_file = 'form::fields.text';
	protected $rules = 'numeric';
	protected $input_type = 'number';
}