<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link" target="_blank">
      <img src="{{ asset('assets/admin/img/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Go to the site</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Main admin page
                <i class="right fas fa-home"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="right fas fa-angle-left"></i>
                  <p>Slider gallery</p>
                </a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('slider.index') }}">
							<i class="far fa-circle nav-icon"></i>
							Slider list
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('slider.create') }}">
							<i class="far fa-circle nav-icon"></i>
							Create slider item
						</a>
					</li>
				</ul>
              </li>
			  <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="right fas fa-angle-left"></i>
                  <p>Categories</p>
                </a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('categories.index') }}">
							<i class="far fa-circle nav-icon"></i>
							Categories list
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('categories.create') }}">
							<i class="far fa-circle nav-icon"></i>
							Create category
						</a>
					</li>
				</ul>
              </li>
			  <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="right fas fa-angle-left"></i>
                  <p>Tags</p>
                </a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('tags.index') }}">
							<i class="far fa-circle nav-icon"></i>
							Tags list
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('tags.create') }}">
							<i class="far fa-circle nav-icon"></i>
							Create tag
						</a>
					</li>
				</ul>
              </li>
			  <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="right fas fa-angle-left"></i>
                  <p>Posts</p>
                </a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('posts.index') }}">
							<i class="far fa-circle nav-icon"></i>
							Posts list
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('posts.create') }}">
							<i class="far fa-circle nav-icon"></i>
							Create post
						</a>
					</li>
				</ul>
              </li>
              <!--<li class="nav-item">
                <a href="../../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>-->
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>