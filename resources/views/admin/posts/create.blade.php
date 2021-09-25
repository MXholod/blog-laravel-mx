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
            <h3 class="card-title">Create a post</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('posts.store') }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
                  </div>
				  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Enter description"></textarea>
                  </div>
				  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" id="content" placeholder="Enter content"></textarea>
                  </div>
				  <div class="form-group">
					@if(count($categories))
					<label for="category_id">Category</label>
					<select id="category_id" name="category_id">
						@foreach($categories as $k_id => $v_title)
							<option value="{{ $k_id }}">{{ $v_title}}</option>
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
							<option value="{{ $k_id }}">{{ $v_title}}</option>
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
				  </div>
                </div>
				<input type="hidden" name="postImages" id="postImages" autocomplete="off" />
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add post</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
  </div>
@endsection


@push('scripts_ckeditor')
	@include('admin.parent_templates.scripts_ckeditor', ['post_id' => null])
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
				extraPlugins: [ SimpleUploadAdapterPlugin ]
			} )
			.catch( error => {
				console.error( error );
		} );
	</script>
@endpush
