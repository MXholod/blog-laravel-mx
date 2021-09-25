@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
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
			<a class="btn btn-primary mb-3" href="{{ route('tags.create') }}">Add tag</a>
			@if(count($tags))
				<div class="table-responsive">
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th style="width: 10%">№ (id)</th>
						  <th style="width: 45%">Tag name</th>
						  <th style="width: 30%">Slug</th>
						  <th style="width: 15%">Actions</th>
						</tr>
					  </thead>
					  <tbody>
						@forelse($tags as $tag)
						<tr>
						  <td>{{ $tag->id }}</td>
						  <td>{{ $tag->title }}</td>
						  <td>
							{{ $tag->slug }}
						  </td>
						  <td>
							<a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="btn btn-info btn-sm float-left mr-1">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="post" class="float-left">
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
								<td colspan="4">Create a tag</td>
							</tr>
						@endforelse
					  </tbody>
					</table>
				</div>
			@else
				<p>There are not any tags</p>
			@endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
			{{ $tags->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection