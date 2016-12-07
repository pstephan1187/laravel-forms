<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Email extends Field
{
	protected $view_file = 'form::fields.text';
	protected $rules = 'email';
	protected $input_type = 'email';
}