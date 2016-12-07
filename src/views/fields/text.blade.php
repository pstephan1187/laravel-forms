<div class="form-group {{ ($errors->has($field->name) ? 'has-error' : '') }}">
	<label for="{{ $field->getAttributes()->get('id') }}" class="control-label">{{ $field->label }}</label>
	<input
		type="{{ $type }}"
		name="{{ $field->name }}"
		class="form-control {{ array_get($field->getAttributes(), 'class') }}"
		value="{{ $field->value }}"
		@foreach(array_except($field->getAttributes()->all(), ['class', 'value']) as $key => $value)
			@if($value === true)
				{{ $key }}
			@else
				{{ $key }}="{{ $value }}"
			@endif
		@endforeach
	>
	@if($errors->has($field->name))
		@foreach($errors->get($field->name) as $error)
			<span class="help-block">{{ $error }}</span>
		@endforeach
	@endif
</div>