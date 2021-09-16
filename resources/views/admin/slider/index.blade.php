@extends('admin.layouts.main_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Slider items</h1>
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
			@if(count($slider_items))
				<a class="btn btn-primary mb-3" href="{{ route('slider.create') }}">Add to the slider</a>
				<div class="table-responsive">
					<table class="table table-bordered">
					  <thead>
						<tr>
						  <th style="width: 5%">№ (id)</th>
						  <th style="width: 15%">Post (title)</th>
						  <th style="width: 20%">Title</th>
						  <th style="width: 20%">Description</th>
						  <th style="width: 20%">Image preview</th>
						  <th style="width: 10%">Date</th>
						  <th style="width: 10%">Actions</th>
						</tr>
					  </thead>
					  <tbody>
						@forelse($slider_items as $slider)
						<tr>
						  <td>{{ $slider->id }}</td>
						  <td>@if($slider->post)
								<span style="font-size:.8em;background-color:lightgreen;">{{ $slider->post->title }}</span>
							  @else
								<span style="font-size:.8em;background-color:lightgrey;">It's not pinned to the slider</span>
							  @endif
						  </td>
						  <td>{{ $slider->title }}</td>
						  <td>
							{!! $slider->description !!}
						  </td>
						  <td>
							Image preview
						  </td>
						  <td>
							{{ $slider->created_at }}
						  </td>
						  <td>
							<a href="{{ route('slider.edit', ['slider' => $slider->id]) }}" class="btn btn-info btn-sm float-left mr-1">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<form action="{{ route('slider.destroy', ['slider' => $slider->id]) }}" method="post" class="float-left">
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
								<td colspan="4">Create to the slider</td>
							</tr>
						@endforelse
					  </tbody>
					</table>
				</div>
			@else
				<p>There are not any sliders</p>
			@endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
			{{ $slider_items->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection