<?php 
include_once('functions.php');
if (!isset($_GET['rpt']) || empty($_GET['rpt'])) {
	header('Location: '.website_url.'login.php');
	die();
} else {
	$query = "SELECT * FROM `users` WHERE `token`='{$_GET['rpt']}'";
	$exicution = mysqli_query($con, $query) or die(mysqli_error($con) ."<br>". $query);
	if (mysqli_num_rows($exicution) < 1) { 
		header('Location: '.website_url.'login.php');
		die();
	}

	while ( $data = mysqli_fetch_array($exicution) ) {
		$token = $data['token'];
		$_SESSION['get_id'] = $data['id'];
	}
}
if (isset($_SESSION['user_id'])){
	header('Location: '.website_url.'/dashboard.php');
	die();
}
if (isset($_POST['n_password']) && isset($_POST['n_password'])) {
	$new_password     = $_POST['n_password'];
	$confirm_password = $_POST['cn_password'];
	if (empty($new_password) || empty($confirm_password)) {
		$new_passwrod_msg = 'Please add <b>New Password</b> and <b>Confirm Password</b>'; 
	} else {
		if ($new_password != $confirm_password) {
			$new_passwrod_msg = '<b>New Password</b> and <b>Confirm Password</b> are not same'; 
		} else {
			$update_query = "UPDATE `users` SET `token`='', `password`='{$new_password}'  WHERE `token`='{$_POST['token']}' limit 1";
			$result = mysqli_query($con,$update_query);
			if ($result) {
				$query = "SELECT * FROM `users` WHERE `id`='{$_SESSION['get_id']}'";
				$exicution = mysqli_query($con, $query) or die(mysqli_error($con) ."<br>". $query);
				if (mysqli_num_rows($exicution) < 1) { die( "No Records Found." ); }
				while ( $data = mysqli_fetch_array($exicution) ) {
					$_SESSION['user_id']         = $data['id'];
					$_SESSION['user_email']      = $data['email'];
					$_SESSION['user_first_name'] = $data['first_name'];
					$_SESSION['user_last_name']  = $data['last_name'];
					header('Location: '.website_url.'/dashboard.php');
					die();
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Change Password</title>
		<link rel="shortcut icon" href="includes/images/smalllogo.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="login_wrapper d-flex flex-column">
		<div class="login_header container py-4">
			<a href="<?php echo website_url ?>">
				<img src="includes/images/Logo.png" class="img-fluid" alt="">
			</a>
		</div>
		<div class="container">
			<div class="login_form_wrap mx-auto w-100 my-4">
				<h1 class="text-center page_title">Change Password</h1>
				<p class="text-center">Enter new password</p>
				<form action="" method="post" class="mt-5 pt-md-4">
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="24px" height="24px" viewBox="-3.994 -4 24 24" enable-background="new -3.994 -4 24 24" xml:space="preserve">
						<path fill="#664D03" d="M8,19.942c6.595,0,11.942-5.347,11.942-11.942S14.595-3.942,8-3.942S-3.942,1.405-3.942,8
						S1.405,19.942,8,19.942z M9.388,5.892l-1.493,7.023c-0.104,0.508,0.043,0.796,0.454,0.796c0.29,0,0.727-0.104,1.024-0.367
						l-0.131,0.621c-0.428,0.516-1.373,0.893-2.187,0.893c-1.049,0-1.496-0.63-1.206-1.969l1.102-5.177
						C7.046,7.275,6.96,7.116,6.522,7.01L5.849,6.889l0.122-0.569L9.39,5.892L9.388,5.892z M8,4.268c-0.824,0-1.493-0.668-1.493-1.493
						S7.176,1.283,8,1.283s1.493,0.668,1.493,1.493S8.824,4.268,8,4.268z"/>
						</svg>
						<?php if (isset($new_passwrod_msg)) { echo $new_passwrod_msg; } else { ?>
							Change Your Password
						<?php } ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					<div class="position-relative my-3">
						<input type="password" name="n_password" class="form-control pe-4" placeholder="New Password" required>
						<button type="button" class="password_toggle_btn">
							<span class="position-relative">
								<img src="includes/images/eye.svg" class="img-fluid" alt="">
							</span>
						</button>
					</div>
					<div class="position-relative my-3">
						<input type="password" name="cn_password" class="form-control pe-4" placeholder="Confirm Password" required>
						<button type="button" class="password_toggle_btn">
							<span class="position-relative">
								<img src="includes/images/eye.svg" class="img-fluid" alt="">
							</span>
						</button>
					</div>
					<input type="hidden" name="token" value="<?php echo $token ?>">
					<button type="submit" class="mt-5">Change Password</button>
				</form>
			</div>
		</div>
		<div class="d-flex login_footer container align-items-cener mt-auto justify-content-between py-4">
			<a href="<?php echo website_url ?>">Privacy Policy</a>
			<span>Copyright 2022</span>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		$('.password_toggle_btn').click(function(event) {
			if ($(this).hasClass('show_pass')) {
				$(this).removeClass('show_pass');
				$(this).siblings('input').attr('type', 'password');
			} else {
				$(this).addClass('show_pass');
				$(this).siblings('input').attr('type', 'text');
			}
		});
	</script>
</body>
</html>