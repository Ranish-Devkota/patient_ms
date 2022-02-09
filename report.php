<?php
include('config.php');
if (isset($_GET['view'])) {
        //extract id from get method:
        $id = $_GET['view'];

        $patient_result = $con->query("SELECT * FROM patients WHERE id = '$id'");

        if(($patient_result->num_rows) != 0){
            //fetch patient details
            $patient = $patient_result->fetch_object();

            $report_result = $con->query("SELECT * FROM reports WHERE patient_id = '$patient->id'");
            
            // while($report = mysqli_fetch_array($report_result))
            // {
            //     // echo $report['id'];
            //     // $reportid = $report['id'];
            //     // $reportfile_result = $con->query("SELECT * FROM report_files WHERE report_id = '$reportid'");

            //     // while($reportfile = mysqli_fetch_array($reportfile_result))
            //     // {
            //     //     // echo $reportfile['file'];
            //     // }
            // }
        }

    }

?>

<?php include('partials/header.php'); ?>

<!-- Sidebar -->
    <?php   
        // session_start();
        // $str = explode('/', $_SESSION["url"]);

        // if($str[2] == 'admin')
        // {
        //     include('admin/sidebar.php');
        // }else
        // {
        //     include('receptionist/sidebar.php');
        // }
        //   include('../sidebar.php');  
    ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <a href="javascript:history.back()" style="text-decoration-line: none;">
                <i class="fa fa-arrow-left"></i>  Back
            </a>
 
            <!-- Topbar Navbar -->
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 ml-3 text-gray-800">Patient Reports</h1>
                <!-- <a href="report_files/1_uttarakhand.jpg" download="newfilename">Download the pdf</a> -->
                <a media="print" href="javascript:window.print();" id="noprint" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                     Generate Report
                </a>
            </div>
            <div class="col-lg-12">
                <!-- Default Card Example -->
                <div class="card mb-4">
                    <div class="card-body bg-gray-100">
                        <div class="row no-gutters align-items-center">
                            <div class="col-lg-12">
                                <div class="h5 font-weight-bold mb-3">
                                    Name :
                                    <?php 
                                        if($patient->middle_name){
                                        echo '<em class="text-val">'.$patient->first_name." ".$patient->middle_name." ".$patient->last_name.'</em>';
                                        }else{
                                        echo '<em class="text-val">'.$patient->first_name." ".$patient->last_name.'</em>';
                                        }
                                    ?>
                                </div>
                                <div class="h5 font-weight-bold mb-3">
                                    Age :
                                    <?php 
                                        echo '<em class="text-val">'.$patient->age.'</em>';
                                    ?>
                                </div>
                                <div class="h5 font-weight-bold mb-3">
                                    Gender :
                                    <?php 
                                        echo '<em class="text-val">'.$patient->gender.'</em>';
                                    ?>
                                </div>
                                <div class="h5 font-weight-bold mb-3">
                                    Phone :
                                    <?php 
                                        echo '<em class="text-val">'.$patient->phone.'</em>';
                                    ?>
                                </div>
                                <div class="h5 font-weight-bold">
                                    Address :
                                    <?php 
                                        echo '<em class="text-val">'.$patient->address.'</em>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                while($report = mysqli_fetch_array($report_result))
                {   
                    $departmentid = $report['department_id'];
                    $department_result = $con->query("SELECT * FROM departments WHERE id = '$departmentid'");

                    if(($department_result->num_rows) != 0){
                        //fetch patient details
                        $department = $department_result->fetch_object();
                    }
                    $doctorid = $report['doctor_id'];
                    $doctor_result = $con->query("SELECT * FROM doctors WHERE id = '$doctorid'");

                    if(($doctor_result->num_rows) != 0){
                        //fetch patient details
                        $doctor = $doctor_result->fetch_object();
                        
                    }
                    echo 
                    '<div class="col-lg-12">
                        <!-- Default Card Example -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    Report
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-lg-12">
                                        <div class="h6 font-weight-bold mb-3">'.
                                            'Department : <em class="text-val">'.$department->name.'</em>
                                        </div>
                                        <div class="h6 font-weight-bold mb-3">';
                                            //if cond for middle name
                                            if($doctor->middle_name){
                                                echo 'Doctor : <em class="text-val">'.$doctor->first_name.' '.$doctor->middle_name.' '.$doctor->last_name.'</em>';
                                            }else{
                                                echo 'Doctor : <em class="text-val">'.$doctor->first_name.' '.$doctor->last_name.'</em>';
                                            }
                                        echo
                                        '</div>
                                        <div class="h6 font-weight-bold mb-0">'.
                                            'Description :
                                            <div class="card border-0 ml-5">
                                                <div class="card-body">
                                                    <p>'.
                                                        '<em class="text-val">'.$report['description'].'</em>'.
                                                    '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="h6 font-weight-bold mb-0">
                                            Prescription :
                                            <div class="card border-0 ml-5">
                                                <div class="card-body">
                                                    <p>'.
                                                        '<em class="text-val">'.$report['prescription'].'</em>'.
                                                    '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="h6 font-weight-bold mb-4">
                                            Related Documents:
                                            <div class="card border-0 mt-3 mb-0" >
                                                <div class="card-body" >
                                                    <div class="text-center">';
                                                        $reportid = $report['id'];
                                                        $reportfile_result = $con->query("SELECT * FROM report_files WHERE report_id = '$reportid'");
                                                        while($reportfile = mysqli_fetch_array($reportfile_result))
                                                        {
                                                            // echo $reportfile['file'];
                                                            echo
                                                            '<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" id="img-print" style="height: 380px;" src="report_files/'.$reportfile['file'].'" alt="...">';
                                                            
                                                        }
                                                    echo
                                                    '</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="h6 font-weight-bold">'.
                                            'Visited at : '.'<em class="text-val">'.$report['visited_at'].'</em>'.
                                        '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            ?>
        </div>
        <!-- ./End Page Content -->
<?php include('partials/footer.php'); ?>