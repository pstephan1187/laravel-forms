<?php

namespace Formery;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class FormBuilder
{
	use ValidatesRequests {
		validate as valiadateInput;
	}

	protected $attributes;
	protected $fields;
	protected $buttons;
	protected $use_csrf = true;
	protected $use_placeholders = false;
	protected $capture_old_input = true;

	public function __construct($action, $method = 'POST')
	{
		$this->attributes = collect();
		$this->fields = collect();
		$this->buttons = collect();

		$this->attributes->put('action', $action);
		$this->attributes->put('method', strtoupper($method));
	}

	public function useCsrf($use = true)
	{
		$this->use_csrf = $use;
	}

	public function usePlaceholders($value = true)
	{
		$this->use_placeholders = $value;

		return $this;
	}

	public function captureOldInput($value = true)
	{
		$this->capture_old_input = $value;

		return $this;
	}

	public function addField($name, $label, $type, $attributes = [])
	{
		$attributes = collect($attributes);

		$Field = new $type($name, $label, $attributes);
		$this->fields->push($Field);

		if($this->use_placeholders){
			$Field->placeholder($label);
		}

		if($this->capture_old_input && ($value = old($name)) !== null){
			$Field->value($value);
		}

		return $Field;
	}

	public function usesCsrf()
	{
		return $this->use_csrf;
	}

	public function addButton($label, $type = 'button', $attributes = [])
	{
		$attributes = collect($attributes)->put('type', $type);

		$this->buttons->push([
			'label' => $label,
			'attributes' => $attributes
		]);

		return $this;
	}

	public function allowUploads()
	{
		$this->attributes->put('enctype', 'multipart/form-data');

		return $this;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getButtons()
	{
		return $this->buttons;
	}

	public function hasButtons()
	{
		return $this->buttons->count() > 0;
	}

	public function render()
	{
		return view('form::form')->with([
			'form' => $this
		]);
	}

	public function validate(Request $request, array $messages = [], array $customAttributes = [])
	{
		$rules = $this->getValidationRules();

		$this->valiadateInput($request, $rules->all(), $messages, $customAttributes);

		return $this;
	}

	public function getValidationRules()
	{
		return $this->fields->reject(function($field){
			return $field->getValidationRules() === null;
		})->mapWithKeys(function($field){
			return [$field->name => $field->getValidationRules()];
		});
	}


}