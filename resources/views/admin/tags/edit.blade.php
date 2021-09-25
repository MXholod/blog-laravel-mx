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
            <h3 class="card-title">Edit chosen tag</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="post" role="form">
				@csrf
				@method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{ $tag->title }}" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update tag</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
  </div>
@endsection