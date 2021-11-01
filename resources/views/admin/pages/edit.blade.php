@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit a page - "{{ $page->title }}"</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('pages.update', ['page' => $page->id]) }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
				@method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title" value="{{ $page->title }}">
                  </div>
				  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" id="content" placeholder="Enter content">{{ $page->content }}</textarea>
                  </div>
				  <div class="form-group">
                    <label>Page displaying</label>
					<span style="background:#f00;border-radius:50%;margin-right:5px;padding-left:5px;">
						No <input type="radio" name="display" value="0" @if($page->display == 0)checked="checked"@endif />
					</span>
					<span style="background:#0f0;border-radius:50%;padding-right:5px;padding-left:5px;">
						Yes <input type="radio" name="display" value="1" @if($page->display == 1)checked="checked"@endif/>
					</span>
                  </div>
				  <div class="form-group">
                    <label>Displaying place</label>
						<select name="display_place">
							<option value="0" @if($page->display_place == 0) selected @endif>Header</option>
							<option value="1" @if($page->display_place == 1) selected @endif>Footer</option>
						</select>
                  </div>
				  <div class="form-group">
					<label for="thumbnail">Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="thumbnail" id="thumbnail" />
							<label for="thumbnail" class="custom-file-label">Choose a file</label>
						</div>
					</div>
					@if(!$page->getImage())
						<span class="alert alert-danger" role="alert" style="position:relative;top:1rem;">
							Image is absent
						</span>
					@else
						<img src="{{ $page->getImage() }}" width="160" height="120" alt="Image preview" class="img-thumbnail" style="position:relative;top:1rem;" />
					@endif
				  </div>
                </div>
                @include('admin.widgets.widget_creation', ['entity' => 'page', 'entityId' => $page->id])
                @include('admin.widgets.widgets_list', [
					'entity' => 'page', 
					'totalWidgets' => $page->widgets(), 
					'widgets' => $page->widgets()->orderBy('created_at', 'desc')->get(), 
					'entityId' => $page->id,
					'routeUpdate' => 'widget.update',
					'routeDelete' => 'widget.destroy'
				])
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update page</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
  </div>
@endsection

@push('scripts_ckeditor')
	<script src="{{ asset('assets/admin/js/CKEditor.js') }}"></script>
	<script>
		//For content
		ClassicEditor
			.create( document.querySelector( '#content' ), {
				toolbar: {
					items: [
						'heading','|','bold','italic','link','bulletedList','numberedList','|',
						'outdent','indent','|','blockQuote','insertTable','undo','redo'
					]
				}
			} )
			.catch( error => {
				console.error( error );
		} );
	</script>
@endpush

@push('scripts_bottom')
	<script>
		//Single widget (form for creation)
		let textAreaWidgetForm = null;
		//List of all existed widgets with data
		let textAreaWidgetList = [];
		//Find CKEditor for widget creation (Widget form)
		const widgetCreationForm = document.querySelector('.widget-creation__block .widget-text');
			//Add CKEditor when widget creates (Widget form)
			addCKEditorToBlock(widgetCreationForm);
		//Get all textareas widget text
		const blocks = document.querySelectorAll('.widget-list .widget-text');
		//Function applies CKEditor to all textareas
		function addCKEditorToBlock(block, formOrList = false){
			return ClassicEditor.create( block, {
				toolbar: {
					items: [
						'heading','|','bold','italic','link','bulletedList','numberedList','|',
						'outdent','indent','|','blockQuote','insertTable','undo','redo'
					]
				}
			} )
			.then( textData => {
				if(!formOrList){
					textAreaWidgetForm = textData;
				}else{
					textAreaWidgetList.push(textData);
				}
			})
			.catch( error => {
				console.error( error );
			} );
		}
			
		$(document).ready(function(){
			//Wrap all textareas with CKEditor
			$(blocks).each(function(){
				//Add CKEditor to each block
				addCKEditorToBlock($(this)[0], true);
			});
			//Hide and show notifications
			if($('.widget-list__blocks').length > 0){
				$('.widget-list__presence').css({ display: 'block' });
				$('.widget-list__absent').css({ display: 'none' });
			}else{
				$('.widget-list__presence').css({ display: 'none' });
				$('.widget-list__absent').css({ display: 'block' });
			}
			
			//Visibility of the block widget creation
			$('#widgetBlockVisibility').on('click',function(){
				$('.widget-creation__block').slideToggle('slow');
			});
			
/* Widget creation */
			$('#widgetCreation').on('click', function(e){
				e.preventDefault();
				//Cover block with shadow
				e.target.parentNode.parentNode.children[2].style.display = "block";
				//Get values from the form
				let _token =   $('form input[name="_token"]').val();
				let title = $.trim($('.widget-creation__block input[name="title"]').val());
				let entityId = $.trim($('.widget-creation__block input[name="entityId"]').val());
				let text = $.trim(textAreaWidgetForm.getData());
				//Checks values
				if(title.length == 0){
					alert("Widget title is empty");
					return;
				}
				if(text.length == 0){
					alert("Widget text is empty");
					return;
				}
				//Make an AJAX request
				$.ajax({
					url: "{{ route('widget.store') }}",
					type: 'POST',
					data:{
						_token,
						title,
						entityId,
						fullText: JSON.stringify(text)
					},
					success: function(data) {
						window.setTimeout(()=>{
							//Insert widgets
							$('.widget-list__blocks').html(data);
								//console.log("Result ",data);
							//Get all textareas widget text
							const getBlocksAgain = document.querySelectorAll('.widget-list .widget-text');
							//Reset array of CKEditor blocks
							textAreaWidgetList = [];
							$(getBlocksAgain).each(function(){
								//Add CKEditor to each block
								addCKEditorToBlock($(this)[0], true);
							});
							//Rewrite clicks to update widget buttons
							processWidget();
							//Cover block with shadow
							e.target.parentNode.parentNode.children[2].style.display = "none";
						},2000);
					},
					error: function(res) {
						console.log("Error ",data);
					}
				});
				//Reset form fields
				$('.widget-creation__block input[name="title"]').val('');
				textAreaWidgetForm.setData('');
			});
/* Update or delete a widget in the list */
			//Find parent block of all widgets
			function processWidget(){
				const widgetList = document.getElementsByClassName('widget-list__blocks')[0];
				if(!widgetList) return;
				widgetList.addEventListener('click', function(e){
					if(e.target.tagName == "BUTTON"){
						let _token =   $('form input[name="_token"]').val();
						let entityId = $.trim($('.widget-creation__block input[name="entityId"]').val());
						let widgetId = e.target.parentNode.parentNode.children[0].children[3].value;
						//Cover block with shadow
						e.target.parentNode.parentNode.children[2].style.display = "block";
						//AJAX settings
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': '{{csrf_token()}}'
							}
						});
						//Update button
						if(e.target.dataset.widget === "update"){
							//Get widget URL with 'id' to update
							let url = e.target.parentNode.parentNode.children[0].children[3].getAttribute('data-update-url');
							let title = e.target.parentNode.parentNode.children[0].querySelector('.widget-title').value;
							//We need widget order to get the correct widget 'textarea' for 'fullText'
							let order = Number(e.target.dataset.widgetOrder);
							let fullText = JSON.stringify(textAreaWidgetList[order].getData());
							//Make an AJAX request
							$.ajax({
								url,
								type: 'PATCH',
								data:{
									'_token': _token,
									'_method': 'PATCH',
									'title': title,
									entityId, //Page id
									fullText,
									widgetId
								},
								success: function(data) {
									window.setTimeout(()=>{
										//Insert widgets
										$('.widget-list__blocks').html(data);
										//Reset array of CKEditor blocks
										textAreaWidgetList = [];
										//Get all textareas widget text
										const getBlocksAgain = document.querySelectorAll('.widget-list .widget-text');
										$(getBlocksAgain).each(function(){
											//Add CKEditor to each block
											addCKEditorToBlock($(this)[0], true);
										});
										//Rewrite clicks to update widget buttons
										processWidget();
										//Uncover block with shadow
										e.target.parentNode.parentNode.children[2].style.display = "none";
									},2000);
								},
								error: function(res) {
									console.log("Error ",res);
								}
							});
						}
						//Delete button
						if(e.target.getAttribute('data-widget') === "delete"){//e.target.dataset.widget === "delete"
							//Get widget URL with 'id' to delete
							let url = e.target.parentNode.parentNode.children[0].children[3].getAttribute('data-delete-url');
							//Make an AJAX request
							$.ajax({
								url,
								type: 'DELETE',
								data:{
									'_token': _token,
									'_method': 'DELETE',
									entityId, //Page id
									widgetId
								},
								success: function(data) {
									window.setTimeout(()=>{
										//Insert widgets
										$('.widget-list__blocks').html(data);
										//Reset array of CKEditor blocks
										textAreaWidgetList = [];
										//Get all textareas widget text
										const getBlocksAgain = document.querySelectorAll('.widget-list .widget-text');
										$(getBlocksAgain).each(function(){
											//Add CKEditor to each block
											addCKEditorToBlock($(this)[0], true);
										});
										//Rewrite clicks to update widget buttons
										processWidget();
										//Uncover block with shadow
										e.target.parentNode.parentNode.children[2].style.display = "none";
									},2000);
								},
								error: function(res) {
									console.log("Error ",res);
								}
							});
						}
						e.preventDefault();
						return false;
					}
				}, false);
			}
			//Find parent block of all widget list on load
			processWidget();
		});
	</script>
@endpush