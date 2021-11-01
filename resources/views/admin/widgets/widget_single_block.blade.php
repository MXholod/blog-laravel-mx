@php $widgetCounter = 0; @endphp
@foreach($widgets as $widget)
	<div class="card widget-list__block">
		<div class="card-body">
			<div class="mb-3">
			  <label class="form-label">Widget title</label>
			  <input class="form-control widget-title" type="text" placeholder="Widget title" aria-label="" value="{{ $widget->title}}">
			</div>
			<div class="mb-3">
			  <label class="form-label">Text for widget</label>
			  <textarea class="form-control widget-text" rows="3" placeholder="Widget content">
					{!! $widget->full_text !!}
			  </textarea>
			</div>
			<input type="hidden" name="entityId" value="{{ $entityId }}" />
			<input type="hidden" name="widgetId" value="{{ $widget->id }}" 
					data-update-url="{{route($routeUpdate, ['id' => $widget->id]) }}"
					data-delete-url="{{route($routeDelete, ['id' => $widget->id]) }}"
			/>
		</div>
		<div class="widget-buttons">
			<button type="button" class="btn btn-sm btn-secondary widget-updates" data-widget="update" data-widget-order="{{ $widgetCounter }}">
				Update widget
			</button>
			<button type="button" class="btn btn-sm btn-danger widget-deletes" data-widget="delete" data-widget-order="{{ $widgetCounter }}">
				Delete widget
			</button>
		</div>
		<div class="widget-list__loader">
			<div class="spinner-grow text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
	@php $widgetCounter++; @endphp
@endforeach