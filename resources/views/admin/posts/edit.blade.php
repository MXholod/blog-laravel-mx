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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
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
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update post</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
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