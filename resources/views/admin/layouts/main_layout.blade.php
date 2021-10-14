<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.parent_templates.header_template')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Errors/Success -->
  @include('admin.parent_templates.errors_success_template')
  <!-- Errors/Succes -->
  <!-- Navbar -->
  @include('admin.parent_templates.top_navbar_template')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.parent_templates.main_sidebar_template')
  
  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  @include('admin.parent_templates.footer_template')
</div>
<!-- ./wrapper -->
@stack('scripts_ckeditor')

<script src="{{ mix('assets/admin/js/admin.js') }}"></script>
<script>
	$(document).ready(function(){
		$('.nav-sidebar a').each(function(){
			// http://laravelblog/management/categories
			let location = window.location.protocol + '//' +window.location.host+window.location.pathname;
			let link = this.href;//Get attribute from 'href' from the current link
			if(link == location){
				$(this).addClass('active');
				$(this).closest('.has-treeview').addClass('menu-open');
			}
		});
		//Initialize Select2 Elements
		$('.select2').select2()
		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})
		//Initialize custom file input
		$(document).ready(function () {
			bsCustomFileInput.init();
		});
	});
</script>
@stack('scripts_bottom')
</body>
</html>
