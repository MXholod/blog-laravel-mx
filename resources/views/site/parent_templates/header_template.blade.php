<header class="header @if(isset($header_logo[0]) && $header_logo[0]->logo_size == 'm') {{ 'header-and-logo'}} @endif">
	<div class="container">
    	<nav class="navbar navbar-inverse" role="navigation">
        	<div class="navbar-header">
            	<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a href="{{ route('home') }}" class="navbar-brand scroll-top logo animated bounceInLeft rollIn">
					@if(isset($header_logo[0]))
						@switch($header_logo[0]->logo_size)
							@case('s')
								<img src="{{ url('downloads/'.$header_logo[0]->logo_img) }}" 
									width="115" 
									height="50" 
									alt="{{ $header_logo[0]->logo_title }}" 
									title="{{ $header_logo[0]->logo_title }}" 
									class="logo-small"/>
								@break
							@case('m')
								<img src="{{ url('downloads/'.$header_logo[0]->logo_img) }}" 
									width="160" 
									height="80" 
									alt="{{ $header_logo[0]->logo_title }}" 
									title="{{ $header_logo[0]->logo_title }}" 
									class="logo-medium"/>
								@break
						@endswitch
					@else
						<b>
							<i class="fa fa-html5">
								{{ env('APP_NAME', 'Your logo here') }}
							</i>
						</b>
					@endif
				</a>
			</div>				
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav" id="mainNavDropDown">
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Profile<b class="caret"></b></a>
                        <ul class="dropdown-menu" id="mainNavDropDownMenu">
                            @auth
								<li>
									<span class="user-name">User: {{ auth()->user()->name }}</span>
									<a href="{{ route('logout') }}">Log out</a>
								</li>
							@endauth
							@guest
								<li><a href="{{ route('register.create') }}">Sign up</a></li>
								<li><a href="{{ route('login.create') }}">Sign in</a></li>
							@endguest
                        </ul>
					</li>
                </ul>
				<ul class="nav navbar-nav" id="mainNav">
                  <li class="active"><a href="{{ route('home') }}">Home</a></li>
				  @foreach($header_links as $header_link)
					<li><a href="/{{ $header_link['slug'] }}">{{ $header_link['title'] }}</a></li>
				  @endforeach
                </ul>
            </div>    
        </nav>
    </div>
</header>
@push('scripts_bottom')
	<script>
		$(document).ready(function(){
			if(!window.sessionStorage.getItem('activeHeaderMenu')){
				let firstAText = $("#mainNav a").first().text().toLowerCase().split(' ').join('-');
				//Initial first menu item as active item if 'sessionStorage' is empty
				window.sessionStorage.setItem('activeHeaderMenu', firstAText);
			}else{
				//Remove all 'active' classes on load
				$("#mainNav").find(".active").removeClass("active");
				$("#mainNavDropDown").first().removeClass("active");
				$("#mainNavDropDownMenu").find(".active").removeClass("active");
				//Get current 'active' from 'sessionStorage'
				let activeItemAfterSignUp = window.sessionStorage.getItem('activeHeaderMenu');
				if(activeItemAfterSignUp === 'sign-up' && $('#mainNavDropDownMenu').children().length < 2){
					//Set 'home' as active after signed up
					let firstAText = $("#mainNav a").first().text().toLowerCase().split(' ').join('-');
					window.sessionStorage.setItem('activeHeaderMenu', firstAText);
				}
				//Get current 'active' from 'sessionStorage'
				let activeItem = window.sessionStorage.getItem('activeHeaderMenu');
				//Set current 'active' class from previous click
				$("#mainNav a").each(function(){
					//If find 'a' by text
					if(activeItem === $(this).text().toLowerCase().split(' ').join('-')){
						$(this).parent().addClass("active");
					}
				});
				//Set current 'active' class from previous click
				$("#mainNavDropDownMenu a").each(function(){
					//If find 'a' by text
					if(activeItem === $(this).text().toLowerCase().split(' ').join('-')){
						$("#mainNavDropDown").first().addClass("active");
						$(this).parent().addClass("active");
					}
				});
			}
			//Get root url and compare with logo url
			$('.logo.animated.bounceInLeft').on("click", function(){
				let logoHref = $(this).attr('href');
				if("{{ route('home') }}" === logoHref){
					//"{{ url()->full() }}"//Laravel helper
					//Set 'home' as active after signed up
					let firstAText = $("#mainNav a").first().text().toLowerCase().split(' ').join('-');
					window.sessionStorage.setItem('activeHeaderMenu', firstAText);
				}
			});
			//Click on each 'a' in main menu
			$("#mainNav a").on("click", function(){
				//Get an 'a' element text
				let firstAText = $(this).text().toLowerCase().split(' ').join('-');
				//Initial first menu item as active item if 'sessionStorage' is empty
				window.sessionStorage.setItem('activeHeaderMenu', firstAText);
			});
			//Click on each 'a' drop down menu
			$("#mainNavDropDownMenu a").on("click", function(){
				//Get an 'a' element text
				let firstAText = $(this).text().toLowerCase().split(' ').join('-');
				if(firstAText === 'log-out'){
					//Set register page as active item if user logs out
					window.sessionStorage.setItem('activeHeaderMenu', 'sign-up');
					return true;
				}
				//Initial first menu item as active item if 'sessionStorage' is empty
				window.sessionStorage.setItem('activeHeaderMenu', firstAText);
			});
		});	
	</script>
@endpush()