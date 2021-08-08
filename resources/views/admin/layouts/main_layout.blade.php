<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.parent_templates.header_template')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- Navbar -->
  @include('admin.parent_templates.top_navbar_template')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.parent_templates.main_sidebar_template')
  
  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  @include('admin.parent_templates.footer_template')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="{{ mix('assets/admin/js/admin.js') }}"></script>
</body>
</html>
