<div class="col-md-4 top3">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Search for posts</h4>
                    <div class="input-group">
						<form method="GET" action="{{ route('search') }}" class="form-search">
							<input type="text" name="search" required class="form-control @error('search') wrong-search @enderror">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</form>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
				@if(count($popular_categories))
                <div class="well">
                    <h4>Popular categories</h4>
                    <div class="row">
                        @if(count($popular_categories))
						<div class="col-lg-6">
                            <ul class="list-unstyled">
								@foreach($popular_categories as $k_slug=>$v_title)
									<li><a href="{{ route('categories.single',['slug' => $k_slug])}}">{{ $v_title }}</a></li>
								@endforeach
                            </ul>
                        </div>
						@endif
						@if(@isset($popular_categories2))
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                @foreach($popular_categories2 as $k_slug2=>$v_title2)
									<li><a href="{{ route('categories.single',['slug' => $k_slug2])}}">{{ $v_title2 }}</a></li>
								@endforeach
                            </ul>
                        </div>
						@endif
                    </div>
                    <!-- /.row -->
                </div>
				@endif
                <!-- Side Widget -->
				@if(isset($page_widgets) && $page_widgets->count())
					@foreach($page_widgets as $k=>$v)
						<div class="well">
							<h4 class="well__widget-header">{{ $k }}</h4>
							<div class="well__widget-content">{!! $v !!}</div>
						</div>
					@endforeach
				@endif
				@if(isset($post_widgets) && $post_widgets->count())
					@foreach($post_widgets as $k=>$v)
						<div class="well">
							<h4 class="well__widget-header">{{ $k }}</h4>
							<div class="well__widget-content">{!! $v !!}</div>
						</div>
					@endforeach
				@endif
				@if(isset($category_widgets) && $category_widgets->count())
					@foreach($category_widgets as $k=>$v)
						<div class="well">
							<h4 class="well__widget-header">{{ $k }}</h4>
							<div class="well__widget-content">{!! $v !!}</div>
						</div>
					@endforeach
				@endif
				<!-- End of Side Widget -->
</div>