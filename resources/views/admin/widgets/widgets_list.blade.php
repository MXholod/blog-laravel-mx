<div class="card-body widget-list">
	<div class="card widget-list__header">
		<p class="h2 widget-list__presence">List of {{ $entity }} widgets</p>
		<p class="widget-list__absent">Widgets are absent</p>
	</div>
	<div class="widget-list__blocks">
		@if($totalWidgets->count())
			@include('admin.widgets.widget_single_block', [
					'widgets' => $widgets, 
					'entityId' => $entityId,
					'routeUpdate' => $routeUpdate,
					'routeDelete' => $routeDelete 
				])
		@endif
	</div>
</div>