<?php include('partials/header.php'); ?>

<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div  style="text-align: center;">
            <div>
                <h1>Patient Management System</h1>
                <p>Manage and Store Patient, Doctors Details and Reports</p>
            </div>
            <div>
                <img src="img/home.jpg" style="width: 80%;" alt="home">
            </div>
            <div style="margin-top: 16px;">
                <a href="userform.php" id="userlogin" role="button" style="margin-right: 305px;">
                    <button class="bth btn-success" style="border-width: 0px; width: 28%; height: 43px; border-radius: 10px;">
                    <h4 class="font-weight-bold" style="margin-top: 7px;"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</h4>
                    </button>
                </a>
                <a  href="login.php" id="userlogin" role="button">
                    <button class="bth btn-danger" style="border-width: 0px; width: 28%; height: 43px; border-radius: 10px;">
                        <h4 class="font-weight-bold" style="margin-top: 7px;">LOGIN</h4>
                    </button>
                </a>
            </div>
        </div>
        <!-- /.container-fluid -->

<?php include('partials/footer.php'); ?>