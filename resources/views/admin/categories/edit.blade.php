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
            <h3 class="card-title">Edit chosen category</h3>
        </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="post" role="form">
				@csrf
				@method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{ $category->title }}" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update category</button>
                </div>
              </form>
            </div>
    <!-- /.content -->
  </div>
@endsection