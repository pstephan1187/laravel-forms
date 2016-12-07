<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Url extends Field
{
	protected $view_file = 'form::fields.text';
	protected $rules = 'url';
	protected $input_type = 'url';
}