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
					<ul>
						@foreach($social as $title=>$link)
							@if($title == 'facebook')
								<a href="{{ $link }}" target="_blank"><i class="fa fa-facebook square"></i></a>
							@elseif($title == 'twitter')
								<a href="{{ $link }}" target="_blank"><i class="fa fa-twitter square"></i></a>
							@elseif($title == 'linkedin')
								<a href="{{ $link }}" target="_blank"><i class="fa fa-linkedin square"></i></a>
							@else
								<a href="{{ $link }}" target="_blank">{{ $title }}</a>
							@endif
						@endforeach
					</ul>
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