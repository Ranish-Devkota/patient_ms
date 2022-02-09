<?php
    session_start();
    if(empty($_SESSION['userLogin']) || $_SESSION['userLogin'] == ''){
        header("Location: ../login.php");
        die();
    }
    
    include('../config.php');

    if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
        
        $result = $con->query("SELECT * FROM patients WHERE id = '$id'");

        if(($result->num_rows) != 0){
            $depart = $result->fetch_object();
            $con->query("DELETE FROM patients WHERE patients.id = $id");
        }
        header("location: index.php");
    }
?>

<?php include('../partials/header.php'); ?>

<!-- Sidebar -->
    <?php   
        // session_start();
        $str = explode('/', $_SESSION["url"]);

        if($str[2] == 'admin')
        {
            include('../admin/sidebar.php');
        }else
        {
            include('../receptionist/sidebar.php');
        }
        //   include('../sidebar.php');  
    ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                
                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter">3+</span>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Alerts Center
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 12, 2019</div>
                                <span class="font-weight-bold">A new monthly report is ready to download!</span>
                            </div>
                        </a>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                    </div>
                </li>

                <!-- Nav Item - User Information -->
                <?php include('../partials/user_data.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Patients</h1>
                <a href="report/create.php" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i 
                        class="fas fa-plus fa-sm text-white-50"></i> Add Report</a>
                <a href="create.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Add Patient</a>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Patients List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Phone</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot> -->
                            <tbody>
                                <!-- list doctors details -->
                                <?php

                                    //for getting department id
                                    $patient_result = $con->query("SELECT * FROM patients;");
                                    
                                    $count = 1;
                                    while($patient = mysqli_fetch_array($patient_result))
                                    {
                                        // echo $patient["id"].'--'.$patient["first_name"]; 
                                        echo '<tr>';
                                        echo '<td>'.$count++.'</td>';
                                        if($patient["middle_name"]){

                                            echo '<td>'.$patient["first_name"].' '.$patient["middle_name"].' '.$patient["last_name"].'</td>';
                                        }
                                        else{

                                            echo '<td>'.$patient["first_name"].' '.$patient["last_name"].'</td>';
                                        }
                                        
                                        echo '<td>'.$patient["age"].'</td>';
                                        echo '<td>'.$patient["gender"].'</td>';
                                        echo '<td>'.$patient["phone"].'</td>';
                                        echo '<td>'.$patient["address"].'</td>';
                                        echo '<td>';
                                        echo '<a class="btn btn-primary btn-sm" href="edit.php?edit='.$patient['id'].'"><i class="fa fa-edit"></i></a>';
                                        echo '<a class="btn btn-info btn-sm" href="report/index.php?view='.$patient['id'].'"><i class="fa fa-eye"></i></a>';
                                        echo "<a class='btn btn-danger btn-sm' href=\"index.php?delete=".$patient['id']."\" OnClick=\"return confirm('Are You Sure?');\"><i class='fa fa-trash'></i></a>";
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

<?php include('../partials/footer.php'); ?>