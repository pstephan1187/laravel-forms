<?php

namespace Formery;

abstract class Field
{
	public $label;
	protected $rules;
	protected $view_file;
	protected $attributes;
	protected $input_type = 'text';

	public function __construct($name, $label, $attributes = [])
	{
		$this->label = $label;
		$this->attributes = collect($attributes);
		$this->attributes->put('name', $name);

		if(!$this->attributes->has('id')){
			$this->attributes->put('id', 'field_'.mt_rand(10000, 99999));
		}
	}

	public function setViewFile($view_file)
	{
		$this->view_file = $view_file;

		return $this;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function getValidationRules()
	{
		return $this->rules;
	}

	public function addRules($rule)
	{
		$rules = (array) $rule;

		foreach($rules as $rule){
			$this->rules .= ($this->rules ? '|'.$rule : $rule);
		}

		return $this;
	}

	public function render()
	{
		return view($this->getViewFile())->with([
			'field' => $this,
			'type' => $this->input_type
		]);
	}

	public function getViewFile()
	{
		if($this->view_file){
			return $this->view_file;
		}

		$name = (new \ReflectionClass($this))->getShortName();
		return 'form::fields.'.snake_case($name);
	}

	public function __call($method, $attributes)
	{
		$value = isset($attributes[0]) ? $attributes[0] : true;
		$this->attributes->put($method, $value);

		return $this;
	}

	public function __set($key, $value)
	{
		$this->attributes->put($key, $value);
	}

	public function __get($key)
	{
		return $this->attributes->get($key);
	}
}