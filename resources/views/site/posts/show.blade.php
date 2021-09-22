@extends('site.layouts.main_layout')

@section('title', $post->title)

@section('content')
<!--Breadcrumbs-->
<div class="col-lg-12 top2">
    <div class="container">
		<ul class="breadcrumb">
		
			<li><a href="{{ route('home') }}">Home</a></li>
			<li>
				<a href="{{ route('categories.single', ['slug' => $post->category->slug])  }}">
					{{ $post->category->title }}
				</a>
			</li>
			<li class="active">{{ $post->title }}</li>
		
		</ul>
	</div>
</div>
<!--Breadcrumbs-->
<div class="col-md-8">
    	<h1>{{ $post->title }}</h1>
        <div class="entry-meta table">
        	<span>
				Views: {{ $post->views }}
            </span>
            <span> / </span>
            <span> {{ $post->category->title }} </span>
            <span> / </span>
            <span> {{ $post->setPostDate() }} </span>
        </div>
        <div>
        	<img src="{{ asset($post->getImage()) }}" class="img-responsive" alt="{{ $post->title }}">
        </div>
        <div class="media">
			{!! $post->content !!}
        </div>
		@if($post->tags->count())
			<div class="tags">
				<span>Tags:</span>
				@foreach($post->tags as $tag)
					<span><a href="{{ route('tags.single',['slug'=>$tag->slug]) }}">{{ $tag->title }}</a></span>
				@endforeach
			</div>
		@else
			<p>This post hasn't any tags</p>
		@endif
    </div>
@endsection