<header class="header">
	<div class="container">
    	<nav class="navbar navbar-inverse" role="navigation">
        	<div class="navbar-header">
            	<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a href="{{ route('home') }}" class="navbar-brand scroll-top logo animated bounceInLeft rollIn"><b><i class="fa fa-html5">Your Logo</i></b></a>
			</div>				
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
					<li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Profile<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @auth
								<li><a href="{{ route('logout') }}">Log out</a></li>
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
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
            </div>    
        </nav>
    </div>
</header>