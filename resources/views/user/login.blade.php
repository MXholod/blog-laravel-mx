@extends('site.layouts.main_layout')
<!--<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>-->

  <!-- Google Font: Source Sans Pro -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ mix('assets/admin/css/admin.css') }}" />
</head>
<body class="hold-transition register-page">-->

@push('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ mix('assets/site/css/admin.css') }}" />
@endpush

@section('content')
<!-- Errors/Success -->
  @include('site.parent_templates.errors_success_template')
<!-- Errors/Succes -->
<div class="col-lg-8">
	<div class="register-box sign-in">
	  <div class="register-logo">
		<b>Sign in</b>
	  </div>

	  <div class="card">
		<div class="card-body register-card-body">
		  <form action="{{ route('login') }}" method="post">
			@csrf
			<div class="input-group mb-3">
			  <input type="email" class="form-control" placeholder="Email" name="email">
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fas fa-envelope"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="password" class="form-control" placeholder="Password" name="password">
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fas fa-lock"></span>
				</div>
			  </div>
			</div>
			<div class="row">
			  
			  <!-- /.col -->
			  <div class="col-4 offset-8">
				<button type="submit" class="btn btn-primary sign-in__btn">Login</button>
			  </div>
			  <!-- /.col -->
			</div>
		  </form>
		</div>
		<!-- /.form-box -->
	  </div><!-- /.card -->
	</div>
</div>
<!-- /.register-box -->
@push('scripts_bottom')
	<script src="{{ mix('assets/admin/js/admin.js') }}"></script>
@endpush

@endsection
<!--
</body>
</html>-->
