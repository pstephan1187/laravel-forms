<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Url extends Field
{
	protected $rules = 'url';
	protected $input_type = 'url';
}