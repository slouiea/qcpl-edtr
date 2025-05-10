<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!-- Add other navbar items here -->
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                    <i class="fas fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">3 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-clock mr-2"></i> 5 employees missing time-in
                        <span class="float-right text-muted text-sm">10 mins ago</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file-alt mr-2"></i> DTR report for Branch A is ready
                        <span class="float-right text-muted text-sm">1 hour ago</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-exclamation-triangle mr-2"></i> 3 employees exceeded overtime limit
                        <span class="float-right text-muted text-sm">2 hours ago</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" role="button">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="dashboard.php" class="brand-link">
            <img src="../logo.png" alt="Brand Logo" class="brand-image" style="opacity: .8">
            <span class="brand-text font-weight-light">QCPL-EDTR</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block"><?php echo $_SESSION['username']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accounts.php" class="nav-link <?php echo $current_page == 'accounts.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Accounts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employees.php" class="nav-link <?php echo $current_page == 'employees.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="timerecords.php" class="nav-link <?php echo $current_page == 'timerecords.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>Time Records</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="branches.php" class="nav-link <?php echo $current_page == 'branches.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Branches</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="generate_dtr.php" class="nav-link <?php echo $current_page == 'generate_dtr.php' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Generate Employee DTR</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php include($content); ?>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Developed By:
            Louie Saguinsin
        <strong>Copyright &copy; 2025 <a href="#">Quezon City Public Library</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- AdminLTE JS -->
<script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
<script>
    $(document).ready(function () {
        // Ensure dropdown functionality works
        $('.dropdown-toggle').dropdown();
    });
</script>
</body>
</html>
