@extends('site.layouts.main_layout')

@section('title', $tag->title)

@section('content')
<!--Breadcrumbs-->
<div class="col-lg-12 top2">
    <div class="container">
		<ul class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li>
				<a href="{{ route('tags.single', ['slug' => $tag->slug])  }}">
					{{ $tag->title }}
				</a>
			</li>
		</ul>
	</div>
</div>
<!--Breadcrumbs-->
<div class="col-md-8">
    <h1>Post(s) by tag: {{ $tag->title }}</h1>
	@foreach($posts as $post)
		<div class="col-md-12">
			<h1>{{ $post->title }}</h1>
			<div class="entry-meta table">
				<span> Tag: {{ $tag->title }} </span>
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
	
	<!--Pagniation-->
	@if(Request::is('tag/'.$tag->slug))
	    <div class="container">
			<div class="row table">
			   <div class="text-center col-lg-8">
					{{ $posts->links() }}
				</div>
			</div>
	    </div>
	@endif
	<!--Pagniation End-->  
</div>
@endsection