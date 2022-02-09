<?php
    session_start();
    if(empty($_SESSION['userLogin']) || $_SESSION['userLogin'] == ''){
        header("Location: ../login.php");
        die();
    }
    
    include('../config.php');

    if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
        
        $result = $con->query("SELECT * FROM patients WHERE id = '$id'");

        if(($result->num_rows) != 0){
            $patient = $result->fetch_object();
        }
    }
?>

<?php
    $empty_field='';
    if(isset($_POST['submit'])){ //check if form was submitted
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        //for getting department id
        if($firstname && $lastname && $age && $address){
            
            $result = $con->query("SELECT id FROM patients WHERE first_name = '".$firstname."' AND last_name = '".$lastname."' AND age = '$age' AND middle_name = '".$middlename."' AND phone='$phone' AND address = '".$address."'");
            
            if(($result->num_rows) == 0){

                $insert= $con->query("UPDATE patients SET first_name = '".$firstname."', middle_name = '".$middlename."', last_name = '".$lastname."', age = '$age', address = '".$address."', phone = '$phone' WHERE patients.id = '$id'");
                echo " updated successfully!!";

                header("location: index.php");
            }else{
                header("location: index.php");
            }
            
        }else{
            $empty_field='Enter all values!';
        }

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
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                <div class="p-5">
                    <div class="text-center  mb-4">
                        <h1 class="h4 text-gray-900">Update Patient Details</h1>
                        <?php 
                            if($empty_field){
                                echo '<p class="text-danger">'.$empty_field.'</p>';
                            }
                        ?>
                    </div>
                    <form class="user" method="POST" action="">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="firstName" name="firstname"
                                    placeholder="First Name" value="<?php echo $patient->first_name ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-user" id="middleName" name="middlename"
                                    placeholder="Middle Name" value="<?php echo $patient->middle_name ?>">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-user" id="lastName" name="lastname"
                                    placeholder="Last Name" value="<?php echo $patient->last_name ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-user" id="age" name="age"
                                placeholder="Age" value="<?php echo $patient->age ?>">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-user" id="gender" name="gender"
                                placeholder="gender" value="<?php echo $patient->gender ?>">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="address" name="address"
                                placeholder="Permanent Address" value="<?php echo $patient->address ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="tel" class="form-control form-control-user" id="phone" name="phone" pattern="[0-9]{10}" required
                                placeholder="Phone Number" value="<?php echo $patient->phone ?>">
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Update"
                        class="btn btn-primary btn-user btn-block"></span>
                        <hr>
                    <div class="text-center">
                        <a class="small" href="index.php">Already have details? Edit!</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./End Page Content -->

<?php include('../partials/footer.php'); ?>