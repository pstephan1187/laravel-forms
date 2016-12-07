<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Checkbox extends Field
{
	protected $options;

	public function __construct($name, $label, $attributes = [], $options = [])
	{
		parent::__construct($name, $label, $attributes);

		$this->options = collect($options);
	}

	public function options($options = [])
	{
		if(count($options) > 0){
			$this->options = $this->options->merge($options);

			return $this;
		}

		return $this->options;
	}

	public function hasValueOf($value)
	{
		if(is_array($this->attributes->get('value'))){
			return in_array($value, $this->attributes->get('value'));
		}

		if($this->attributes->get('value') == $value){
			return true;
		}

		return false;
	}
}