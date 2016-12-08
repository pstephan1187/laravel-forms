<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Email extends Field
{
	protected $rules = 'email';
	protected $input_type = 'email';
}