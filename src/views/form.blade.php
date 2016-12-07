<form @foreach($form->getAttributes() as $key => $value) {{ $key }}="{{ $value }}" @endforeach>
	@if($form->usesCsrf())
		{!! csrf_field() !!}
	@endif
	
	@foreach($form->getFields() as $field)
		<div class="row">
			<div class="col-xs-12">
				{!! $field->render() !!}
			</div>
		</div>
	@endforeach
	
	@if($form->hasButtons())
	<div class="row">
		<div class="col-xs-12">
			@foreach($form->getButtons() as $button)
				<button
					class="btn btn-primary {{ array_get($button['attributes'], 'class') }}"
					@foreach(array_except($button['attributes'], ['class']) as $key => $value)
						{{ $key }}="{{ $value }}"
					@endforeach
				>
					{{ $button['label'] }}
				</button>
			@endforeach
		</div>
	</div>
	@endif

</form>