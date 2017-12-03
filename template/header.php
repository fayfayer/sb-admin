<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <!-- jquery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>

  </head>

  <body class="fixed-nav sticky-footer bg-dark" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="/sb-admin">Start Bootstrap</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <?php 
            if (isset($_GET["menu"])) {
                $menu = $_GET["menu"];
                $uri = explode("/", $menu);
                $uri = $uri[0];
            } else {
                $uri = "";
            }
         ?>
          <li class="nav-item <?php echo !isset($menu) ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Home">
            <a class="nav-link" href="/sb-admin">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">
                Home</span>
            </a>
          </li>

          <li class="nav-item <?php echo $uri == 'customers' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Charts">
            <a class="nav-link" href="?menu=customers">
              <i class="fa fa-fw fa-area-chart"></i>
              <span class="nav-link-text">
                Customers</span>
            </a>
          </li>

          <li class="nav-item <?php echo $uri == 'employees' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="right" title="Tables">
            <a class="nav-link" href="?menu=employees">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">
                Employees</span>
            </a>
          </li>
		  <!--
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-file"></i>
              <span class="nav-link-text">
                Example Pages</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseExamplePages">
              <li>
                <a href="login.html">Login Page</a>
              </li>
              <li>
                <a href="register.html">Registration Page</a>
              </li>
              <li>
                <a href="forgot-password.html">Forgot Password Page</a>
              </li>
              <li>
                <a href="blank.html">Blank Page</a>
              </li>
            </ul>
          </li>
		  -->
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
            <a class="nav-link" href="?menu=users">
              <i class="fa fa-users"></i>
              <span class="nav-link-text">
                Users</span>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout</a>
          </li>
        </ul>

      </div>
    </nav>

    <div class="content-wrapper">

      <div class="container-fluid">