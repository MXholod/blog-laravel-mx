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
                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>
</div>