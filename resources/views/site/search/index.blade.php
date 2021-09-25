@extends('site.layouts.main_layout')

@section('title', $title)

@section('content')
<div class="col-lg-8">
	@if($posts->count())
	@foreach($posts as $post)
		<div class="col-md-12">
			<h1>{{ $post->title }}</h1>
			<div class="entry-meta table">
				<span> Category: {{ $post->category->title }} </span>
				<span> / </span>
				<span>
					Views: {{ $post->views }}
				</span>
				<span> / </span>
				<span> Post created: {{ $post->setPostDate() }} </span>
			</div>
			<div>
				@if($post->thumbnail)
					<img src="{{ asset('downloads/'.$post->thumbnail) }}" class="img-responsive" alt="fashion">
				@endif
			</div>
			<div class="media">
				{!! $post->description !!}
			</div>
			<div class="read-more padding text-center">
				<a class="btn btn-default btn-hover" href="{{ route('posts.single', ['slug'=>$post->slug]) }}" role="button">Read More</a>
			</div>
		</div>
	@endforeach
	@else
		<div class="col-md-12">
			<h3>Nothing found...</h3>
		</div>
	@endif
	
	<!--Pagniation-->
	@if(Request::is('search') && $posts->count())
	    <div class="container">
			<div class="row table">
			   <div class="text-center col-lg-8">
					{{ $posts->appends([ 'search' => request()->search ])->links() }}
				</div>
			</div>
	    </div>
	@endif
	<!--Pagniation End-->
</div>
@endsection