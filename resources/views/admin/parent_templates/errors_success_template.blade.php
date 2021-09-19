<div class="container">
	<div class="row">
		<div class="col-12">
			@if ($errors->any())
				<div class="alert alert-danger" style="position:relative;top:0;left:12%;">
					<ul class="list-unstyled">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (session()->has('success'))
				<div class="alert alert-success" style="position:relative;top:0;left:12%;">
				   {{ session('success') }}
				</div>
			@endif
			@if (session()->has('error'))
				<div class="alert alert-danger" style="position:relative;top:0;left:12%;">
				   {{ session('error') }}
				</div>
			@endif
		</div>
	</div>
</div>