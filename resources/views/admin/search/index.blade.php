@extends('admin.layouts.main_layout')

@section('title', $title)

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>The result of the posts found</h1>
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
			@if($posts->count())
				<div class="table-responsive">
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th style="width: 5%">№ (id)</th>
						  <th style="width: 15%">Slider (title)</th>
						  <th style="width: 20%">Post name</th>
						  <th style="width: 20%">Category</th>
						  <th style="width: 15%">Tags</th>
						  <th style="width: 5%">Views</th>
						  <th style="width: 10%">Date</th>
						  <th style="width: 10%">Actions</th>
						</tr>
					  </thead>
					  <tbody>
						@foreach($posts as $post)
						<tr>
						  <td>{{ $post->id }}</td>
						  <td>@if($post->slider)
								<span style="font-size:.8em;background-color:lightgreen;">{{ $post->slider->title }}</span>
							  @else
								<span style="font-size:.8em;background-color:lightgrey;">It's not pinned to the slider</span>
							  @endif
						  </td>
						  <td>{{ $post->title }}</td>
						  <td>
							{{ $post->category->title }}
						  </td>
						  <td>
							@if(count($post->tags))
								{{ $post->tags->pluck('title')->join(', ') }}
							@else
								Post hasn't tags
							@endif
						  </td>
						  <td>
							{{ $post->views }}
						  </td>
						  <td>
							{{ $post->created_at }}
						  </td>
						  <td>
							<a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-info btn-sm float-left mr-1">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post" class="float-left">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete it?')">
									<i class="fas fa-trash-alt"></i>
								</button>
							</form>
						  </td>
						</tr>
						@endforeach
					  </tbody>
					</table>
				</div>
			@else
				<div class="col-md-12">
					<h3>Nothing found...</h3>
				</div>
			@endif
        </div>
        <!-- /.card-body -->
        <!--Pagniation-->
		@if(Request::is('management/search') && $posts->count())
			<div class="container">
				<div class="row table">
				   <div class="text-center col-lg-8">
						{{ $posts->appends([ 'search' => request()->search ])->links() }}
					</div>
				</div>
			</div>
		@endif
		<!--Pagniation End-->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection