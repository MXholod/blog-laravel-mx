@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Posts</h1>
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
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $title }}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
			<a class="btn btn-primary mb-3" href="{{ route('posts.create') }}">Add post</a>
			@if(count($posts))
				<div class="table-responsive">
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th style="width: 5%">№ (id)</th>
						  <th style="width: 24%">Post name</th>
						  <th style="width: 20%">Category</th>
						  <th style="width: 20%">Tags</th>
						  <th style="width: 20%">Date</th>
						  <th style="width: 11%">Actions</th>
						</tr>
					  </thead>
					  <tbody>
						@forelse($posts as $post)
						<tr>
						  <td>{{ $post->id }}</td>
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
						@empty
							<tr>
								<td colspan="4">Create a post</td>
							</tr>
						@endforelse
					  </tbody>
					</table>
				</div>
			@else
				<p>There are not any posts</p>
			@endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
			{{ $posts->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection