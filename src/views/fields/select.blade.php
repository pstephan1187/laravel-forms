<div class="form-group {{ ($errors->has($field->name) ? 'has-error' : '') }}">
	<label for="{{ $field->getAttributes()->get('id') }}" class="control-label">{{ $field->label }}</label>
	<select
		name="{{ $field->name }}"
		class="form-control {{ array_get($field->getAttributes(), 'class') }}"
		@foreach(array_except($field->getAttributes()->all(), ['class', 'value']) as $key => $value)
			@if($value === true)
				{{ $key }}
			@else
				{{ $key }}="{{ $value }}"
			@endif
		@endforeach
	>
		@foreach($field->options() as $option)
			@if(isset($option['options']))
				<optgroup label="{{ $option['label'] }}">
					@foreach($option['options'] as $optgroup_option)
						<option
							value="{{ array_get($optgroup_option, 'value') }}"
							{{ array_get($optgroup_option, 'disabled', false) ? 'disabled' : '' }}
							{{ $field->hasValueOf(array_get($optgroup_option, 'value')) ? 'selected' : '' }}
						>
							{{ $optgroup_option['label'] }}
						</option>
					@endforeach
				</optgroup>
			@else
				<option
					value="{{ array_get($option, 'value') }}"
					{{ array_get($option, 'disabled', false) ? 'disabled' : '' }}
					{{ $field->hasValueOf(array_get($option, 'value')) ? 'selected' : '' }}
				>
					{{ $option['label'] }}
				</option>
			@endif
		@endforeach()
	</select>
	@if($errors->has($field->name))
		@foreach($errors->get($field->name) as $error)
			<span class="help-block">{{ $error }}</span>
		@endforeach
	@endif
</div>