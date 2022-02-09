<?php 
$empty_field='';
include('config.php');

?>
<?php include('partials/header.php');
        if(isset($_POST['submit'])){ //check if form was submitted

            
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $lastname = $_POST['lastname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            if( $firstname && $lastname && $age && $gender && $phone )
            {
            $patient_result = $con->query("SELECT id FROM patients WHERE first_name = '$firstname' AND middle_name = '$middlename' AND last_name = '$lastname' AND age = '$age' AND gender = '$gender'");
           
             $patient_data = $patient_result->fetch_object();
            $patient_id = $patient_data->id;
            header("location: report.php?view=$patient_id");
            }
            
        }

?>

<!-- Sidebar -->
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <a href="javascript:history.back()" style="text-decoration-line: none;">
                <i class="fa fa-arrow-left"></i>  Back
            </a>
 
            <!-- Topbar Navbar -->
        </nav>
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                <div class="p-5">
                    <div class="text-center mb-4">
                        <h1 class="h4 text-gray-900"> Patient Report</h1>
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
                                    placeholder="First Name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-user" id="middleName" name="middlename"
                                    placeholder="Middle Name">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-user" id="lastName" name="lastname"
                                    placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-user" id="age" name="age"
                                placeholder="Age">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-user" id="gender" name="gender"
                                placeholder="gender">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="address" name="address"
                                placeholder="Permanent Address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="tel" class="form-control form-control-user" id="phone" name="phone" pattern="[0-9]{10}" required
                                placeholder="Phone Number">
                            </div>
                        </div>
                        <input type="submit" name="submit" value=" Get Report"
                        class="btn btn-primary btn-user btn-block">
                        <hr>
                    
                </div>
            </div>
        </div>

    <?php include('partials/footer.php'); ?>