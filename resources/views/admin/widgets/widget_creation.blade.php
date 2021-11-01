<div id="widget-creation" class="card-body">
	<div class="card widget-creation__header">
		<p class="h2">Create and add a new widget to the {{ $entity }}</p>
		<button id="widgetBlockVisibility" type="button" class="btn btn-sm btn-info">
			Show widget creation block
		</button>
	</div>	
	<div class="card widget-creation__block">
		<div class="card-body">
			<div class="mb-3">
			  <label class="form-label">Widget title</label>
			  <input class="form-control widget-title" name="title" value="" type="text" placeholder="Widget title">
			</div>
			<div class="mb-3">
			  <label class="form-label">Text for widget</label>
			  <textarea class="form-control widget-text" rows="3" name="text" placeholder="Widget content"></textarea>
			</div>
			<input type="hidden" name="entityId" value="{{ $entityId }}" />
		 </div>
		 <div class="widget-buttons">
			<button type="click" id="widgetCreation" class="btn btn-sm btn-primary">
				Create widget
			</button>
		</div>
		<div class="widget-creation__loader">
			<div class="spinner-grow text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
</div>
