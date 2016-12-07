<?php

namespace Formery\FieldTypes;

use Formery\Field;

class Radio extends Field
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
}