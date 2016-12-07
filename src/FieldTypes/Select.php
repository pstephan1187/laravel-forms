<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Select extends Field
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

	public function default($label, $value = '')
	{
		$this->options->prepend(['label' => $label, 'value' => $value, 'disabled' => true]);

		if(!$this->attributes->has('value')){
			$this->attributes->put('value', $value);
		}

		return $this;
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