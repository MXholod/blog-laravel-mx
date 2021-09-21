<header class="header">
	<div class="container">
    	<nav class="navbar navbar-inverse" role="navigation">
        	<div class="navbar-header">
            	<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a href="{{ route('home') }}" class="navbar-brand scroll-top logo animated bounceInLeft rollIn"><b><i class="fa fa-html5">Your Logo</i></b></a></div>				
              <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav" id="mainNav">
                  <li class="active"><a href="{{ route('home') }}">Home</a></li>
                  <li><a href="about.html">About Us</a></li>
                              <li class="dropdown">
                               <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="single-post.html">Single-Post</a></li>
                                    <li><a href="gallery.html">Gallery</a></li>
                                    <li><a href="full-page.html">Full Page</a></li>
                                    <li><a href="#">Page4</a></li>
                                </ul>
                            </li>
                  <li><a href="blog.html">Blog</a></li>
                  <li><a href="contact.html">Contact Us</a></li>
                </ul>
              </div>    
        </nav>
    </div>
</header>