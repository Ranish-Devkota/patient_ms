<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Patient_MS - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary"> 

    <?php
        include('config.php');
        session_start();
        $empty_field = "";
        if(isset($_POST['login']))
        {
            $email=$_POST['email'];
            $password=$_POST['password'];

            // echo $email.'--'.$password;
            if($email && $password)
            {
                // code here 
                // $result_pass = $con->query("SELECT password FROM users WHERE email = '".$email."'");
                // $result_mail = $con->query("SELECT email FROM users WHERE password = '".$password."'");
                $result = $con->query("SELECT email, password, role, status FROM users WHERE email = '".$email."' AND  password = '".$password."'");

                if(($result->num_rows) > 0){
                    $user_data = $result->fetch_object();
                    if((($user_data->role) == 1) && (($user_data->status) == 1)){
                        $_SESSION['userLogin'] = "Loggedin";
                        header("Location: admin/index.php");
                    }
                    elseif(($user_data->role) == 2 && (($user_data->status) == 1)){
                        $_SESSION['userLogin'] = "Loggedin";
                        header("Location: receptionist/index.php");
                    }

                }else{
                    $empty_field = "User not registered!!";
                }

            }else{
                $empty_field = "Missing email or password!!!";
            }
        }
    ?>  

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">Welcome Back!</h1>
                                        <?php 
                                            if($empty_field){
                                                echo '<p class="text-danger">'.$empty_field.'</p>';
                                            }
                                        ?>
                                    </div>
                                    <form class="user" method = "post" action="login.php">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                                                                 
                                                
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> 
                                        <input type="submit" name="login" value="Login"
                                        class="btn btn-primary btn-user btn-block"></span>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="#">Create an Account!</a>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="btn btn-dashboard btn-user btn-block" href="index.php">
                                            Visit Website</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/sb-admin-2.js"></script>

</body>

</html>