<div class="form-group {{ ($errors->has($field->name) ? 'has-error' : '') }}">
	<label class="control-label">{{ $field->label }}</label>
	@foreach($field->options() as $option)
		<div class="checkbox">
			<label>
				<input
					type="checkbox"
					name="{{ $field->name }}[]"
					value="{{ $option['value'] }}"
					{{ $field->hasValueOf(array_get($option, 'value')) ? 'checked' : '' }}
					@foreach(array_except($field->getAttributes()->all(), ['value', 'name']) as $key => $value)
						@if($value === true)
							{{ $key }}
						@else
							{{ $key }}="{{ $value }}"
						@endif
					@endforeach
				>
				{{ $option['label'] }}
			</label>
		</div>
	@endforeach
	
	@if($errors->has($field->name))
		@foreach($errors->get($field->name) as $error)
			<span class="help-block">{{ $error }}</span>
		@endforeach
	@endif
</div>