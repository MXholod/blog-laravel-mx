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
                <!-- /.card-body -->
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