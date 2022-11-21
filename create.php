<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary601 = $username = $password ="";
$name_err = $address_err = $salary601_err = $username_err =$password_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary601
    $input_salary601 = trim($_POST["salary601"]);
    if(empty($input_salary601)){
        $salary601_err = "Please enter the salary601 amount.";     
    } elseif(!ctype_digit($input_salary601)){
        $salary601_err = "Please enter a positive integer value.";
    } else{
        $salary601 = $input_salary601;
    }

    // Validate username
if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
} elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
    $username_err = "Username can only contain letters, numbers, and underscores.";
} else{
    // Prepare a select statement
    $sql = "SELECT id FROM employees WHERE username = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        
        // Set parameters
        $param_username = trim($_POST["username"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                $username_err = "This username is already taken.";
            } else{
                $username = trim($_POST["username"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Validate confirm password
if(empty(trim($_POST["password"]))){
    $password_err = "Please confirm password.";     
} else{
    $password = trim($_POST["password"]);
    if(empty($password_err) && ($password != $password)){
        $password_err = "Password did not match.";
    }
}
 
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary601_err)&& empty($username_err)&& empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary601, username, password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiss", $param_name, $param_address, $param_salary601, $param_username, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary601 = $salary601;
            $param_username = $username;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: welcome.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<title>create</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="The Venue template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link href="plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="plugins/jquery-timepicker/jquery.timepicker.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/create.css">
<link rel="stylesheet" type="text/css" href="styles/create_responsive.css">
</head>
<body>

<div class="super_container">
	
	<!-- Header -->

	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="header_content d-flex flex-row align-items-center justify-content-start">
						<div class="logo">
							<a href="#">
								<div>LUCA’S LOAVES</div>
								<div>❤</div>
							</a>
						</div>
						<nav class="main_nav">
							<ul class="d-flex flex-row align-items-center justify-content-start">
								<li><a href="index.html">home</a></li>
								<li><a href="about.html">about us</a></li>
								<li><a href="careers.html">careers</a></li>
								<li><a href="login.php">orderonline</a></li>
								<li><a href="create.php">register</a></li>
								<li><a href="contact.html">contact</a></li>
							</ul>
						</nav>
						<div class="reservations_phone ml-auto">Reservations: +86 601</div>
					</div>
				</div>
			</div>
		</div>
	</header>


	
	<!-- Home -->

	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/blog1.png" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div class="home_subtitle page_subtitle">Sweet</div>
							<div class="home_title"><h1>Register your account and become one of us!
</h1></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>





	<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>salary601</label>
                            <input type="text" name="salary601" class="form-control <?php echo (!empty($salary601_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary601; ?>">
                            <span class="invalid-feedback"><?php echo $salary601_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        
                        <a href="create.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>




	

<!-- Footer -->

<footer class="footer">
	<div class="container">
		<div class="row">

			<!-- Footer Logo -->
			<div class="col-lg-3 footer_col">
				<div class="footer_logo">
					<div class="footer_logo_title">LUCA’S LOAVES</div>
					<div class="footer_logo_subtitle">❤</div>
				</div>
				<div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
<p style="line-height: 1.2;">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by 20IT1 Drake Wenxing Chen 203190601</a></p>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
			</div>

			<!-- Footer About -->
			<div class="col-lg-6 footer_col">
				<div class="footer_about">
				<center><p>There is bread, there is love, food is delicious, and health goes hand in hand</p></center>
				</div>
			</div>

			<!-- Footer Contact -->
			<div class="col-lg-3 footer_col">
				<div class="footer_contact">
					<ul>
						<li class="d-flex flex-row align-items-start justify-content-start">
							<div><div class="footer_contact_title">Name</div></div>
							<div class="footer_contact_text">Drake Wenxing Chen</div>
						</li>
						<li class="d-flex flex-row align-items-start justify-content-start">
							<div><div class="footer_contact_title">StudentID:</div></div>
							<div class="footer_contact_text">+86 203190601</div>
						</li>
						<li class="d-flex flex-row align-items-start justify-content-start">
							<div><div class="footer_contact_title">Email:</div></div>
							<div class="footer_contact_text">1732235081@qq.com</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap-4.1.2/popper.js"></script>
<script src="styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="plugins/jquery-datepicker/jquery-ui.js"></script>
<script src="plugins/jquery-timepicker/jquery.timepicker.js"></script>
<script src="js/blog.js"></script>
</body>
</html>