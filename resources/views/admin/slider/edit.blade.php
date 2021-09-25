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
            <h3 class="card-title">Edit a slider - "{{ $slider->title }}"</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('slider.update', ['slider' => $slider->id]) }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
				@method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $slider->title }}">
                  </div>
				  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" id="description">{!! $slider->description !!}</textarea>
                  </div>
				  <div class="form-group">
					@if(count($posts))
					<label for="p_slug">Post</label>
					<select id="p_slug" name="p_slug">
						@foreach($posts as $k_slug => $v_title)
							
							<option value="{{ $k_slug }}" @if($k_slug == $slider->post_slug) selected @endif>
								{{ $v_title}}
							</option>
						@endforeach
					</select>
					@else
						<p>There are no posts</p>
					@endif
				  </div>
				  <div class="form-group">
					<label for="thumbnail">Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="path_img" id="thumbnail" />
							<label for="thumbnail" class="custom-file-label">Choose a file</label>
						</div>
					</div>
					@if(!$slider->getImage())
						<span class="alert alert-danger" role="alert" style="position:relative;top:1rem;">
							Message is absent
						</span>
					@else
						<img src="{{ $slider->getImage() }}" width="160" height="120" alt="Image preview" class="img-thumbnail" style="position:relative;top:1rem;" />
					@endif
				  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update slider</button>
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
	</script>
@endpush