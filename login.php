<?php 
include_once('functions.php');
if (isset($_SESSION['user_id'])){
	header('Location: '.website_url.'dashboard.php');
	die();
}
if (isset($_POST['user_email']) && isset($_POST['password'])) {
	$user_email = $_POST['user_email'];
	$password = $_POST['password'];
	if (empty($user_email) || empty($password)) {
		$login_status = 'Please enter correct email and password';
	}
	$query = "SELECT * FROM `users` WHERE `email`='{$user_email}' limit 1";
	$exicution = mysqli_query($con, $query) or die(mysqli_error($con) ."<br>". $query);
	if (mysqli_num_rows($exicution) < 1) {
		$login_status = 'Your email is not registered';
	}
	while ( $data = mysqli_fetch_array($exicution) ) {
		if ($password != $data['password']) {
			$login_status = 'Your password is incorrct';
		} else {
			if ($user_email == $data['email'] && $password == $data['password'] ) {
				$_SESSION['user_id']         = $data['id'];
				$_SESSION['user_email']      = $data['email'];
				$_SESSION['user_first_name'] = $data['first_name'];
				$_SESSION['user_last_name']  = $data['last_name'];
				$_SESSION['security_error']  = $data['token'];
				if (isset($_POST['remeber_user'])) {
					setcookie('user_id', $data['id'], time()+86400*7);
					setcookie('user_email', $data['email'], time()+86400*7);
					setcookie('user_first_name', $data['first_name'], time()+86400*7);
					setcookie('user_last_name', $data['last_name'], time()+86400*7);
				}
				if (!empty($_SESSION['security_error'])) {
					$_SESSION['security_error'] = 'Please update your password';
					header('Location: '.website_url.'settings.php');
					die();
				}
				header('Location: '.website_url.'/dashboard.php');
				die();
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
	<title>Sign in</title>
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
				<h1 class="text-center page_title">Sign in</h1>
				<p class="text-center">Sign in to use Hands for Charity</p>
				<form action="" method="post" class="mt-5 pt-md-4">
					<?php if ((isset($login_status) && !empty($login_status)) || isset($_SESSION['statusMsg']) && !empty($_SESSION['statusMsg'])): ?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						width="24px" height="24px" viewBox="-3.994 -4 24 24" enable-background="new -3.994 -4 24 24" xml:space="preserve">
						<path fill="#664D03" d="M8,19.942c6.595,0,11.942-5.347,11.942-11.942S14.595-3.942,8-3.942S-3.942,1.405-3.942,8
						S1.405,19.942,8,19.942z M9.388,5.892l-1.493,7.023c-0.104,0.508,0.043,0.796,0.454,0.796c0.29,0,0.727-0.104,1.024-0.367
						l-0.131,0.621c-0.428,0.516-1.373,0.893-2.187,0.893c-1.049,0-1.496-0.63-1.206-1.969l1.102-5.177
						C7.046,7.275,6.96,7.116,6.522,7.01L5.849,6.889l0.122-0.569L9.39,5.892L9.388,5.892z M8,4.268c-0.824,0-1.493-0.668-1.493-1.493
						S7.176,1.283,8,1.283s1.493,0.668,1.493,1.493S8.824,4.268,8,4.268z"/>
					</svg>
					<?php if (isset($_SESSION['statusMsg']) && !empty($_SESSION['statusMsg'])){
						$login_status = $_SESSION['statusMsg'];
					} ?>
					<?php echo $login_status;  $_SESSION['statusMsg'] = ''?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
					<?php endif ?>
					<input type="email" name="user_email" class="form-control" placeholder="Username or email">
					<div class="position-relative my-3">
						<input type="password" name="password" class="form-control pe-4" placeholder="Password">
						<button type="button" class="password_toggle_btn">
							<span class="position-relative">
								<img src="includes/images/eye.svg" class="img-fluid" alt="">
							</span>
						</button>
					</div>
					<div class="d-flex align-items-center justify-content-between">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remmeber_user" id="remmeber_user1" value="option1">
							<label class="form-check-label" for="remmeber_user1">
								Remember me
							</label>
						</div>
						<a class="forgot_link" href="<?php echo website_url ?>forgot-password.php">
							<b>
								Forgot Password?
							</b>
						</a>
					</div>
					<button type="submit" class="mt-5">Sign In</button>
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