@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pages</h1>
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
			<a class="btn btn-primary mb-3" href="{{ route('pages.create') }}">Add page</a>
			@if(count($pages))
				<div class="table-responsive">
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th style="width: 5%">№ (id)</th>
						  <th style="width: 20%">Page name</th>
						  <th style="width: 20%">Page slug</th>
						  <th style="width: 15%">Page display</th>
						  <th style="width: 15%">Displaying place</th>
						  <th style="width: 5%">Widgets</th>
						  <th style="width: 10%">Date</th>
						  <th style="width: 10%">Actions</th>
						</tr>
					  </thead>
					  <tbody>
						@forelse($pages as $page)
						<tr>
						  <td>{{ $page->id }}</td>
						  <td>{{ $page->title }}</td>
						  <td>
							{{ $page->slug }}
						  </td>
						  <td>
							@if($page->display == 0)
								The page is hidden
							@else
								The page is displayed
							@endif
						  </td>
						  <td>
							@switch($page->display_place)
								@case(0)
									Link in header
									@break
								@case(1)
									Link in footer
									@break
								@default
									Default case...
							@endswitch
						  </td>
						  <td>
							{{ $page->widgets()->count() }}
						  </td>
						  <td class="date-column">
							{{ $page->setPostDate() }}
						  </td>
						  <td>
							<a href="{{ route('pages.edit', ['page' => $page->id]) }}" class="btn btn-info btn-sm float-left mr-1">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<form action="{{ route('pages.destroy', ['page' => $page->id]) }}" method="post" class="float-left">
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
								<td colspan="4">Create a page</td>
							</tr>
						@endforelse
					  </tbody>
					</table>
				</div>
			@else
				<p>There are not any pages</p>
			@endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
			{{ $pages->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection