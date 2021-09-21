@if(count($allSlides))
<div class="slider_outer">
	<div id="slider1_container" style="position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
            <div style="position: absolute; display: block; background: url({{ asset('assets/site/images/loading.gif') }}) no-repeat center center; top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
        </div>
        <!-- Slides Container -->
		<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px;
            height: 500px; overflow: hidden;">
            @foreach($allSlides as $slider)
			<div>
                <img u="image" src="{{ asset('downloads/'.$slider->path_img) }}" />
                
                <div style="position: absolute; width: 480px; height: 120px; top: 30px; left: 30px; padding: 5px;
                    text-align: left; line-height: 60px; text-transform: uppercase; font-size: 50px; color: #FFFFFF;">
					{{ $slider->title }}
                </div>
                <div style="position: absolute; width: 480px; height: 120px; top: 300px; left: 30px; padding: 5px;
                    text-align: left; line-height: 36px; font-size: 30px;
                        color: #FFFFFF;">
                        {!! $slider->description !!}
                </div>
				<a href="{{ route('posts.single', ['slug' => $slider->post_slug]) }}" class="slider-post-link">
					Go to the post {{ $slider->title }}
				</a>
            </div>
			@endforeach
        </div>
                
        
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>
        
        
        <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
        </span>
        
        <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
        </span>
        
    </div>
</div>
@else
	<p>Slider place</p>
@endif

@push('scripts_bottom')
	@if(count($allSlides))
		<script src="{{asset('assets/site/js/slider.js')}}" type="text/javascript"></script>
	@endif
@endpush
