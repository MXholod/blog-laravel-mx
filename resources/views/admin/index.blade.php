@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Main Page</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $title }}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
			<div class="container">
				<div class="row">
				    <b class="ml-2 pr-2">Total amount of:</b> Categories, Posts, Tags, Sliders and Pages in this application
				    <table class="table table-striped table-bordered mt-3">
					  <thead>
						<tr>
						  <th scope="col" style="width:20%">Categories</th>
						  <th scope="col" style="width:20%">Posts</th>
						  <th scope="col" style="width:20%">Tags</th>
						  <th scope="col" style="width:20%">Slides</th>
						  <th scope="col" style="width:20%">Pages</th>
						</tr>
					  </thead>
					  <tbody>
						<tr>
						  <th scope="row">{{ $categories->count() }}</th>
						  <td>{{ $posts->count() }}</td>
						  <td>{{ $tags->count() }}</td>
						  <td>{{ $sliders->count() }}</td>
						  <td>{{ $pages->count() }}</td>
						</tr>
					  </tbody>
					</table>
				</div>
				<div class="row">
					@include('admin.logo.logo_management', ['logo' => $logo])
				</div>
			</div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection