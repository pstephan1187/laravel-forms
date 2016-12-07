<div class="form-group {{ ($errors->has($field->name) ? 'has-error' : '') }}">
	<label class="control-label">{{ $field->label }}</label>
	@foreach($field->options() as $option)
		<div class="radio">
			<label>
				<input
					type="radio"
					value="{{ $option['value'] }}"
					{{ $field->value == array_get($option, 'value') ? 'checked' : '' }}
					@foreach(array_except($field->getAttributes()->all(), ['value']) as $key => $value)
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