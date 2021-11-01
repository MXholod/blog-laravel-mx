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
            <h3 class="card-title">Edit a post - "{{ $post->title }}"</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
				@method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $post->title }}">
                  </div>
				  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" id="description">{{ $post->description }}</textarea>
                  </div>
				  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" id="content" >{{ $post->content }}</textarea>
                  </div>
				  <div class="form-group">
					@if(count($categories))
					<label for="category_id">Category</label>
					<select id="category_id" name="category_id">
						@foreach($categories as $k_id => $v_title)
							
							<option value="{{ $k_id }}" @if($k_id == $post->category_id) selected @endif>
								{{ $v_title}}
							</option>
						@endforeach
					</select>
					@else
						<p>There are no categories</p>
					@endif
				  </div>
				  <div class="form-group">
					@if(count($tags))
					<label for="tags">Tags</label>
					<select multiple="multiple" id="tags" name="tags[]" class="select2" data-placeholder="Tag selection" style="width:100%;">
						@foreach($tags as $k_id => $v_title)
							<option value="{{ $k_id }}" @if(in_array($k_id, $post->tags->pluck('id')->all())) selected @endif>
								{{ $v_title}}
							</option>
						@endforeach
					</select>
					@else
						<p>There are no tags</p>
					@endif
				  </div>
				  <div class="form-group">
					<label for="thumbnail">Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="thumbnail" id="thumbnail" />
							<label for="thumbnail" class="custom-file-label">Choose a file</label>
						</div>
					</div>
					@if(!$post->getImage())
						<span class="alert alert-danger" role="alert" style="position:relative;top:1rem;">
							Image is absent
						</span>
					@else
						<img src="{{ $post->getImage() }}" width="160" height="120" alt="Image preview" class="img-thumbnail" style="position:relative;top:1rem;" />
					@endif
				  </div>
                </div>
				<input type="hidden" name="postImages" id="postImages" autocomplete="off" />
                <!-- /.card-body -->
				@include('admin.widgets.widget_creation', ['entity' => 'post', 'entityId' => $post->id])
                @include('admin.widgets.widgets_list', [
					'entity' => 'post', 
					'totalWidgets' => $post->widgets(), 
					'widgets' => $post->widgets, 
					'entityId' => $post->id,
					'routeUpdate' => 'post.widget.update',
					'routeDelete' => 'post.widget.destroy'
				])
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update post</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
    <!-- comments -->
	<div class="container">
		<div class="row">
			<div class="col">
				@if($comments->count())
					@include('admin.comments.comment_block', ['comments' => $comments, 'id' => $post->id]) 
				@else
					<p id="noComments" style="text-align:center;">
						<b style="background:#f6f6f6;border-radius:5px;padding:4px 20px;">
						There are no comments for this post</b>
					</p>
				@endif
			</div>
		</div>
	</div>
    <!-- end comments -->
  </div>
@endsection

@push('scripts_ckeditor')
	@include('admin.parent_templates.scripts_ckeditor', ['post_id' => $post->id])
	<script>
	
		//For description
		ClassicEditor
			.create( document.querySelector( '#description' ), {
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
		//For content
		ClassicEditor
			.create( document.querySelector( '#content' ),  {
				extraPlugins: [ SimpleUploadAdapterPlugin ],
				// Add Image to the plugin list.
				//plugins: [ window.InsertImage ],
				image: {
					toolbar: [ 'imageStyle:inline',
								'imageStyle:block',
								'imageStyle:side',
								'|',
								'toggleImageCaption',
								'imageTextAlternative'
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
					url: "{{ route('post.widget.store') }}",
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