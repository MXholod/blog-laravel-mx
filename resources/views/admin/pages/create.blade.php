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
            <h3 class="card-title">Create a page</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('pages.store') }}" method="post" role="form" enctype="multipart/form-data">
				@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
                  </div>
				  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" id="content" placeholder="Enter content"></textarea>
                  </div>
				  <div class="form-group">
                    <label>Page displaying</label>
					<span style="background:#f00;border-radius:50%;margin-right:5px;padding-left:5px;">
						No <input type="radio" name="display" value="0" checked="checked" />
					</span>
					<span style="background:#0f0;border-radius:50%;padding-right:5px;padding-left:5px;">
						Yes <input type="radio" name="display" value="1" />
					</span>
                  </div>
				  <div class="form-group">
                    <label>Displaying place</label>
						<select name="display_place">
							<option value="0">Header</option>
							<option value="1">Footer</option>
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
				  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add page</button>
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
