@extends('site.layouts.main_layout')

@section('title', $page[0]->title)

@section('content')
<div class="col-lg-8">
	<div class="container" style="margin-top:2em;">
		<div class="row">
			<div class="col-lg-4">
				<h1>{{ $page[0]->title }}</h1>
			</div>
			<div class="col-lg-4">
				@if($page[0]->thumbnail)
					<img src="{{asset($page[0]->getImage())}}" class="img-thumbnail" />
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				{!! $page[0]->content !!}
			</div>	
		</div>
	</div>
</div>
@endsection