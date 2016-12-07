<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Password extends Field
{
	protected $view_file = 'form::fields.text';
	protected $input_type = 'password';
}