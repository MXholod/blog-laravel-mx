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
            <h3 class="card-title">Create a slide</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
			@if($totalPosts <= 0)
				<p>You do not have a post to which you can apply the image</p>
			@else
              <form action="{{ route('slider.store') }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
                  </div>
				  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Enter description"></textarea>
                  </div>
				  <div class="form-group">
					@if(count($posts))
					<label for="post_slug">Available post(s)</label>
					<select id="post_slug" name="post_slug">
						@foreach($posts as $k_slug => $v_title)
							<option value="{{ $k_slug }}">{{ $v_title}}</option>
						@endforeach
					</select>
					@else
						<p style="font-weight:bold;background-color:lightgrey;width:40%;padding:5px;">
							There are no posts to add to the slider
						</p>
					@endif
				  </div>
				  <div class="form-group">
					<label for="image">Slider image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="path_img" id="image" />
							<label for="image" class="custom-file-label">Choose a slider image</label>
						</div>
					</div>
				  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add to the slider</button>
                </div>
              </form>
			@endif
            </div>
    <!-- /.content -->
  </div>
@endsection


@push('scripts_ckeditor')
	@include('admin.parent_templates.scripts_ckeditor', ['post_id' => null])
	<script>
		//For description
		const description = document.querySelector( '#description' );
		if(description){
			ClassicEditor
				.create( description, {
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
		}
	</script>
@endpush
