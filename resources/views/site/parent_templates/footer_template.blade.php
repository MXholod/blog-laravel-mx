<footer>
	<div class="row">
                <div class="col-lg-4">
                	<h1>Popular Posts</h1>
                    <ul class="list-unstyled">
                    	@foreach($popular_posts as $popular_post)
						<li>
							<a href="{{ route('posts.single', ['slug' => $popular_post->slug]) }}">
								{{ $popular_post->title }}
							</a>
							<span class="popular-post-views">Total views: {{ $popular_post->views }}</span>
						</li>
						@endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                <h1>Like Us</h1>
                    <div class="text-center">
                        <a href="https://www.facebook.com/themesrefinery"><i class="fa fa-facebook square"></i></a>
                        <a href="https://twitter.com/themesrefinery"><i class="fa fa-twitter square"></i></a>
                        <a href="#"><i class="fa fa-github square"></i></a>
                        <a href="https://plus.google.com/b/101108467301668768757/+Themesrefinery57/posts"><i class="fa fa-google-plus square"></i></a>
                    </div>
					<ul class="nav nav-pills" style="margin-top:2em;">
					  @foreach($footer_links as $footer_link)
						<li class="nav-item">
							<a href="{{ $footer_link['slug'] }}" class="nav-link active" aria-current="page">{{ $footer_link['title'] }}</a>
						</li>
					  @endforeach
					</ul>
                </div>
                <div class="col-lg-4">
                	<h1>Recent Posts</h1>
                	<ul class="list-unstyled">
                    	@foreach($recent_posts as $recent_post)
						<li>
							<a href="{{ route('posts.single', ['slug' => $recent_post->slug]) }}">
								{{ $recent_post->title }}
							</a>
						</li>
						@endforeach
                    </ul>
                </div>
    </div>
    <div class="col-lg-12 top2 bottom2">
    	<div class="text-center">Copy Right &copy; @php echo date('Y') @endphp Design By Mike</div>
    </div>
</footer>