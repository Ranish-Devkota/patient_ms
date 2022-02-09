<?php
    session_start();
    if(empty($_SESSION['userLogin']) || $_SESSION['userLogin'] == ''){
        header("Location: ../../login.php");
        die();
    }
    
    include('../../config.php');

    $empty_field='';

    if(isset($_POST['submit'])){ //check if form was submitted
        $department_name = $_POST['name']; //get input text
        
        if($department_name){
            $result = $con->query("SELECT name FROM departments WHERE name = '".$department_name."'");

            if(($result->num_rows) == 0){
                $con->query("INSERT INTO `departments` (`name`) VALUES ('".$department_name."');");
                echo $department_name." inserted successfully!!";
                header("location: index.php");
            }else{
                echo $department_name." already exist!!";
            }
        }else{
            $empty_field = "Enter all values!";
        }

    }
?>

<?php include('../../partials/header.php'); ?>

<!-- Sidebar -->
<?php include('../sidebar.php'); ?>
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
                <?php include('../../partials/user_data.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
                <!-- Card Body -->
            <div class="card-body">
                <div class="p-5">
                    <div class="text-center mb-4">
                        <h1 class="h4 text-gray-900">Register Department</h1>
                        <?php 
                            if($empty_field){
                                echo '<p class="text-danger">'.$empty_field.'</p>';
                            }
                        ?>
                    </div>
                    <form class="user" method="POST" action="">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="name" name="name"
                                    placeholder="Department Name">
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Register Department"
                        class="btn btn-primary btn-user btn-sm"></span>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="index.php">Already have details? Edit!</a>
                    </div>
                </div>
            </div>
        </div>
        

<?php include('../../partials/footer.php'); ?>