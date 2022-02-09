<?php
    session_start();
    if(empty($_SESSION['userLogin']) || $_SESSION['userLogin'] == ''){
        header("Location: ../../login.php");
        die();
    }

    include('../../config.php');

    $empty_field='';

    if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
        
        $result = $con->query("SELECT * FROM reports WHERE id = '$id'");

        if(($result->num_rows) != 0){
            $report = $result->fetch_object();

            $patn_result = $con->query("SELECT * FROM patients WHERE patients.id = '$report->patient_id'");
            $patn_data = $patn_result->fetch_object();

            $dpt_result = $con->query("SELECT * FROM departments WHERE departments.id = '$report->department_id'");
            $dpt_data = $dpt_result->fetch_object();

            $dct_result = $con->query("SELECT * FROM doctors WHERE doctors.id = '$report->doctor_id'");
            $dct_data = $dct_result->fetch_object();
        }
    }

    if(isset($_POST['submit'])){ //check if form was submitted

        $patientid = $_POST['patientid'];
        $date = $_POST['date'];
        $department = $_POST['department'];
        $doctorid = $_POST['doctorid'];
        $description = $_POST['description'];
        $prescription = $_POST['prescription'];

        //for getting department id
        if($patientid && $department && $doctorid && $description){

            $patient_result = $con->query("SELECT id FROM patients WHERE id = '$patientid'");
            $patient_data = $patient_result->fetch_object();
            $patient_id = $patient_data->id;
            
            $department_result = $con->query("SELECT id, name FROM departments WHERE name = '$department'");
            $department_data = $department_result->fetch_object();
            $department_id = $department_data->id;

            $doctor_result = $con->query("SELECT id FROM doctors WHERE id = '$doctorid'");
            $doctor_data = $doctor_result->fetch_object();
            $doctor_id = $doctor_data->id;

            if((($patient_result->num_rows) != 0) && (($department_result->num_rows) != 0) && (($doctor_result->num_rows) != 0) ){

                if($date)
                {
                    $con->query("UPDATE reports SET `patient_id` = '$patient_id', `department_id` = '$department_id', `doctor_id` = '$doctor_id', `visited_at` = '$date', `description` = '".$description."', `prescription` = '".$prescription."' WHERE reports.id = '$report->id';");
                    
                }
                else{
                    $con->query("UPDATE reports SET `patient_id` = '$patient_id', `department_id` = '$department_id', `doctor_id` = '$doctor_id', `description` = '".$description."', `prescription` = '".$prescription."' WHERE reports.id = '$report->id';");
                    // echo " inserted successfully!!";
                }
                
                echo " inserted successfully!!";

                if(isset($_FILES['file'])){
                    // Delete existing files
                    // $file_result = $con->query("SELECT * FROM report_files WHERE report_id = '$report->id'");
                    // var_dump(isset($_FILES['file']));
                    // die();
                    // while($file = mysqli_fetch_array($file_result))
                    // {
                    //     $file_path = "/opt/lampp/htdocs/patient_ms/report_files/".$file['file'];
                    //     unlink($file_path);
                    //     $con->query("DELETE FROM report_files WHERE id = ".$file['id']);
                        
                    //     echo "deleted successfully".unlink($file_path);
                    // }

                    $countfiles = count($_FILES['file']['name']);

                    // Looping all files
                    for($i=0;$i<$countfiles;$i++){

                        $tmpFilePath = $_FILES['file']['tmp_name'][$i];

                        //Make sure we have a file path
                        if ($tmpFilePath != ""){
                            //Setup our new file path
                            $newFilePath = "/opt/lampp/htdocs/patient_ms/report_files/" . "$report->id" . "_" . $_FILES['file']['name'][$i];

                            //Upload the file into the temp dir
                            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                                //Handle other code here
                                $con->query("INSERT INTO `report_files` (`report_id`, `file`) VALUES ('$report->id', '". "$report->id" . "_" . $_FILES['file']['name'][$i]."');");
                                // echo "uploaded sucessfully!";
                            }
                        }
                        // echo $_FILES['file']['tmp_name'][$i];

                    }
                    header("location: index.php?view=".$patient_id);
                }
                // header("location: index.php?view=".$patient_id);
            }else{
                echo "data not found!!";
            }
        }else{
            $empty_field = "Enter all values!";
        }
        

    }
    
?>

<?php include('../../partials/header.php'); ?>

<!-- Sidebar -->
    <?php   
        // session_start();
        $str = explode('/', $_SESSION["url"]);

        if($str[2] == 'admin')
        {
            include('../../admin/sidebar.php');
        }else
        {
            include('../../receptionist/sidebar.php');
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
                        <h1 class="h4 text-gray-900">Updating Patient Report</h1>
                        <?php 
                            if($empty_field){
                                echo '<p class="text-danger">'.$empty_field.'</p>';
                            }
                        ?>
                    </div>
                    <form class="user" method="POST" action="" enctype='multipart/form-data'>
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <select type="select" class="form-control" id="patientid" name="patientid" style="height: 50px; border-radius: 1rem;">
                                    <?php 
                                        if($patn_data->middle_name){
                                            echo 
                                            '<option value="'.$patn_data->id.'" selected hidden>'.$patn_data->first_name.' '.$patn_data->middle_name.' '.$patn_data->last_name.'</option>';
                                        }else{
                                            echo 
                                            '<option value="'.$patn_data->id.'" selected hidden>'.$patn_data->first_name.' '.$patn_data->last_name.'</option>';
                                        }

                                        $pat_result = $con->query("SELECT * FROM patients ORDER BY first_name ASC;");

                                        while($pat = mysqli_fetch_array($pat_result))
                                        {
                                            if($pat["middle_name"]){

                                                echo '<option value="'.$pat["id"].'">'.$pat["first_name"].' '.$pat["middle_name"].' '.$pat["last_name"].'</option>' ;
                                            }
                                            else{

                                                echo '<option value="'.$pat["id"].'">'.$pat["first_name"].' '.$pat["last_name"].'</option>' ;
                                            }
                                            
                                        }
                                        
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2" style="text-align: right; margin-top: 16px!important;">
                                <h6 class="m-0">Visited At:</h6>
                            </div>
                            <div class="col-sm-5">
                                <input type="date" class="form-control form-control-user" id="date" name="date"
                                placeholder="Visited At" value=<?php 
                                    $date_value = strtotime($report->visited_at);
                                    echo date("Y-m-d", $date_value);
                                    ?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <select type="select" class="form-control" id="department" name="department" style="height: 50px; border-radius: 1rem;">
                                    <?php
                                        echo
                                        '<option value="'.$dpt_data->name.'" selected hidden>'.$dpt_data->name.'</option>';
                                     
                                        $departs_result = $con->query("SELECT * FROM departments ORDER BY name ASC;");

                                        while($depart = mysqli_fetch_array($departs_result))
                                        {
                                            echo '<option value="'.$depart["name"].'">'.$depart["name"].'</option>' ; 
                                        }
                                        // var_dump($departs);
                                        // die();
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select type="select" class="form-control" id="doctorid" name="doctorid" style="height: 50px; border-radius: 1rem;">
                                    <?php
                                        if($patn_data->middle_name){
                                            echo 
                                            '<option value="'.$dct_data->id.'" selected hidden>'.$dct_data->first_name.' '.$dct_data->middle_name.' '.$dct_data->last_name.'</option>';
                                        }else{
                                            echo
                                            '<option value="'.$dct_data->id.'" selected hidden>'.$dct_data->first_name.' '.$dct_data->last_name.'</option>';
                                        }
                                        $dct_result = $con->query("SELECT * FROM doctors ORDER BY first_name ASC;");

                                        while($dct = mysqli_fetch_array($dct_result))
                                        {
                                            if($dct["middle_name"]){

                                                echo '<option value="'.$dct["id"].'">'.$dct["first_name"].' '.$dct["middle_name"].' '.$dct["last_name"].'</option>' ;
                                            }
                                            else{
    
                                                echo '<option value="'.$dct["id"].'">'.$dct["first_name"].' '.$dct["last_name"].'</option>' ;
                                            }
                                        }
                                        // var_dump($departs);
                                        // die();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <!-- <input type="discreption" class="form-control form-control-user" id="discreption" name="discreption"
                                placeholder="Description"> -->
                                <textarea class="form-control" id="discreption" name="description" style="height: 152px; border-radius:24px;"
                                placeholder="Description"><?php echo $report->description ?></textarea>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <!-- <input type="discreption" class="form-control form-control-user" id="discreption" name="discreption"
                                placeholder="Description"> -->
                                <textarea class="form-control" id="prescription" name="prescription" style="height: 152px; border-radius:24px;"
                                placeholder="Prescription" ><?php echo $report->prescription ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group" >
                            <label for="">Report Files</label>
                                <div class="row">
                                    <div class="customer_records" style=" margin-left: 10px; margin-bottom: 12px;">
                                        <input name="file[]" type="file" multiple>

                                        <!-- <a class="extra-fields-customer btn btn-success btn-sm btn-circle" href="#"><b>+</b></a> -->
                                    </div> 
                                    <!-- <div class="customer_records_dynamic"></div>  -->
                                </div>
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

<?php include('../../partials/footer.php'); ?>