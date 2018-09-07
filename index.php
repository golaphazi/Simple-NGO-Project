<?php
session_start();
require_once("db_connect.php");
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <title><?= comapny_info('COMPANY_NAME');?></title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/jquery.js"></script>
   <!-- BOOTSTRAP SCRIPTS  -->
    <script src="js/bootstrap.js"></script>
</head>
<body>
  <?php
	$mass ='';
	if(isset($_POST['submit_login'])){
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if(strlen($email) > 0 AND strlen($password) > 0){
			$search = query("SELECT * FROM s_user_table WHERE USER_MAIL = '".$email."' AND USER_PASS = '".$password."'");
			if(num_row($search) == 1){
				$fetch = fetch($search);
				$userID = $fetch['USER_ID'];
				$name = $fetch['USER_NAME'];
				$type = $fetch['USER_TYPE'];
				
				$_SESSION['USER_ID'] = $userID;
				$_SESSION['USER_NAME'] = $name;
				$_SESSION['USER_TYPE'] = $type;
				
			}else{
				$mass = 'Wrong Email and Password';
			}
		
		}else{
			$mass = 'Pleasee Enter Email and Password';
		}
	}
	
	$userIDLoogin = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '';
	$typeLogin 	= isset($_SESSION['USER_TYPE']) ? $_SESSION['USER_TYPE'] : '';
	if($userIDLoogin > 0 AND strlen($typeLogin) > 0){
		pageRedirect('login.php');
		//echo '<script>window.location = "'.host().'/login.php";</script>';
	}
	
  ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            
            <div class="row">
                <form action="" method="POST">
				<div class="col-md-3"></div>
				<div class="col-md-6 login_box">
                  
                     <h3>Login Account </strong></h3>
						<p><?= $mass;?></p>
                        <div class="form-group">
							<label for="email">Email ID  </label>
							<input type="text" name="email" id="email" class="form-control" />
                        </div>
						<div class="form-group">
							<label for="password">Password   </label>
							<input type="password" id="password" name="password" class="form-control" />
                        </div>
						<div class="form-group">
							<button class="btn btn-info" name="submit_login" type="submit"><span class="glyphicon glyphicon-user"></span> &nbsp;Log In </button>&nbsp;
						</div>
				</div>
				<div class="col-md-3"></div>
                </form>

            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
 
</body>
</html>
