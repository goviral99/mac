<?php

include_once('functions.php');
if (!isset($_SESSION['user_id'])) {
	$_SESSION['statusMsg'] = 'Please Login To Access Your Dashboard';
	header('Location:'.website_url.'/login.php');
	die();
}
if (isset($_POST['trx_rf']) && !empty($_POST['trx_rf'])) {
	$user_fn = $_SESSION['user_first_name'];
	$user_email = $_SESSION['user_email'];
	$trx_id = $_POST['trx_rf'];
	$trx_cause = $_POST['trx_cause'];
	$trx_reason = $_POST['trx_reason'];
	$to = 'admin@goviralproductions.com';
    $subject = "Donation Refund Request";   

    $message = "
    <html>
        <head>
            <title>Donation Refund Request</title>
        </head>
        <body>
            <p>User <b>$user_fn</b> has requested for a refund</p>
            <table border='0' cellpadding='0' cellspacing='0' width='400' align='left' style='text-align: left'>
                <tr>
                    <td align='left' style='padding: 5px 0; border-bottom: 1px solid #eee; border-top: 1px solid #eee'>
                    <b>First Name</b>:<br>
                    $user_fn
                    </td>
                </tr>
                <tr>
                    <td align='left' style='padding: 5px 0; border-bottom: 1px solid #eee'>
                    <b>Email</b>:<br>
                    $user_email
                    </td>
                </tr>
                <tr>
                    <td align='left' style='padding: 5px 0; border-bottom: 1px solid #eee'>
                    <b>Transaction ID</b>:<br>
                    $trx_id
                    </td>
                </tr>
                <tr>
                    <td align='left' style='padding: 5px 0; border-bottom: 1px solid #eee'>
                    <b>Cause</b>:<br>
                    $trx_cause
                    </td>
                </tr>
                <tr>
                    <td align='left' style='padding: 5px 0; border-bottom: 1px solid #eee'>
                    <b>Reason</b>:<br>
                    $trx_reason
                    </td>
                </tr>
            </table>
        </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: noreply@handsforcharity.org';

    mail($to, $subject, $message, $headers);

	$query = "SELECT * FROM `transactions` WHERE `uid`='{$user_id}' and `trx_id`='{$_POST['trx_rf']}' limit 1";
	$exicution = mysqli_query($con, $query) or die(mysqli_error($con) ."<br>". $query);
if (mysqli_num_rows($exicution) < 1) { die( "No Records Found." ); }
	while ( $data = mysqli_fetch_array($exicution) ) {		
		$refund = $stripe->refunds->create([
			'charge' => $data['trx_id'],
		]);
		if (!empty($refund)) {
			if ($refund['object'] == 'refund' && $refund['status'] == 'succeeded') {
				$refund_id = $refund['id'];
				$r_object = $refund['object'];
				$r_charge = $refund['charge'];
				$update_query = "UPDATE `transactions` SET `refund_id`='{$refund_id}', `refund` = '{$r_object}' WHERE `uid`='{$user_id}' and `trx_id`='{$r_charge}'";
				$result = mysqli_query($con,$update_query);
				if ($result) {
					echo mysqli_affected_rows($con) . "<br>";
				} else{
					echo mysqli_error($con) . "<br>";
				}
				
			}
		}
	}
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
		<link rel="shortcut icon" href="includes/images/smalllogo.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="dashboard_wrapper position-relative d-flex overflow-hidden">
		<div class="dashboard_sidebar d-flex flex-column">
			<a href="" class="logo">
				<img src="includes/images/Logo.png" class="img-fluid" alt="Logo">
			</a>
			<ul class="list-unstyled mb-0 side_nav mt-4 mb-4">
				<li>
					<a href="<?php echo website_url ?>/dashboard.php" class="active">
						<svg width="20px" height="20px" viewBox="0 0.5 20 20" enable-background="new 0 0.5 20 20" xml:space="preserve">
							<g>
								<path fill="none" d="M17.225,6.472l-5.747-4.027c-1.06-0.744-2.808-0.707-3.822,0.084L2.644,6.435
								c-0.66,0.521-1.246,1.702-1.246,2.539v6.891c0,1.776,1.441,3.227,3.218,3.227h10.768c1.776,0,3.217-1.441,3.217-3.217v-6.77
								C18.602,8.211,17.96,6.974,17.225,6.472z M10.697,16.068c0,0.381-0.316,0.697-0.697,0.697s-0.697-0.316-0.697-0.697v-2.79
								c0-0.381,0.316-0.697,0.697-0.697s0.697,0.316,0.697,0.697V16.068z"/>
								<path fill="#292D32" d="M18.025,5.328l-5.747-4.027c-1.562-1.097-3.971-1.042-5.477,0.13L1.789,5.337
								C0.785,6.119,0.003,7.709,0.003,8.973v6.891c0,2.548,2.064,4.622,4.612,4.622h10.768c2.548,0,4.612-2.074,4.612-4.612v-6.77
								C19.997,7.755,19.132,6.1,18.025,5.328z M18.602,15.873c0,1.776-1.441,3.217-3.217,3.217H4.616c-1.776,0-3.218-1.451-3.218-3.227
								V8.973c0-0.837,0.586-2.018,1.246-2.539l5.012-3.906c1.014-0.79,2.762-0.828,3.822-0.084l5.747,4.027
								c0.735,0.502,1.376,1.739,1.376,2.632V15.873z"/>
								<path fill="#292D32" d="M10,12.581c-0.381,0-0.697,0.316-0.697,0.697v2.79c0,0.381,0.316,0.697,0.697,0.697
								s0.697-0.316,0.697-0.697v-2.79C10.697,12.897,10.381,12.581,10,12.581z"/>
							</g>
						</svg>
						One-Time Donations
					</a>
				</li>
				<li>
					<a href="<?php echo website_url ?>/donation-list.php">
						<svg x="0px" y="0px" width="20px" height="20px" viewBox="0 0.5 20 20" enable-background="new 0 0.5 20 20" xml:space="preserve">
							<g>
								<path fill="none" d="M13.466,2.159h-6.93c-3.011,0-3.502,0.532-3.502,3.795v10.322c0,0.997,0.256,1.461,0.428,1.461
								c0.19,0,0.594-0.194,1.106-0.741c0.496-0.533,1.147-0.827,1.832-0.827c0.77,0,1.495,0.377,1.987,1.033l0.927,1.239
								c0.393,0.519,0.968,0.523,1.368-0.003l0.923-1.234c0.93-1.241,2.763-1.343,3.821-0.205c0.515,0.548,0.918,0.743,1.109,0.743
								c0.171,0,0.424-0.463,0.424-1.456V5.953c0.004-1.747-0.194-2.693-0.664-3.163C15.853,2.348,15.006,2.159,13.466,2.159z
								M6.43,10.683c-0.607,0-1.104-0.493-1.104-1.1c0-0.607,0.488-1.1,1.096-1.1H6.43c0.607,0,1.1,0.493,1.1,1.1
								C7.53,10.19,7.038,10.683,6.43,10.683z M6.43,7.017c-0.607,0-1.104-0.493-1.104-1.1s0.488-1.1,1.096-1.1H6.43
								c0.607,0,1.1,0.493,1.1,1.1S7.038,7.017,6.43,7.017z M14.032,10.409H8.991c-0.455,0-0.825-0.37-0.825-0.825
								c0-0.455,0.37-0.825,0.825-0.825h5.041c0.455,0,0.825,0.37,0.825,0.825C14.857,10.039,14.487,10.409,14.032,10.409z M14.032,6.741
								H8.991c-0.455,0-0.825-0.37-0.825-0.825s0.37-0.825,0.825-0.825h5.041c0.455,0,0.825,0.37,0.825,0.825S14.487,6.741,14.032,6.741z"
								/>
								<path fill="#292D32" d="M17.462,1.625c-0.979-0.981-2.499-1.116-3.996-1.116h-6.93c-3.948,0-5.152,1.272-5.152,5.445v10.322
								c0,2.293,1.074,3.111,2.078,3.111c0.748,0,1.525-0.425,2.312-1.265c0.39-0.417,0.951-0.386,1.293,0.07l0.929,1.242
								c0.511,0.675,1.241,1.062,2.001,1.062c0.761,0,1.49-0.388,2.003-1.067l0.925-1.236c0.345-0.457,0.901-0.492,1.296-0.069
								c0.787,0.841,1.566,1.268,2.314,1.268c1.003,0,2.074-0.815,2.074-3.106V5.955C18.612,4.306,18.476,2.641,17.462,1.625z
								M16.958,16.285c0,0.993-0.254,1.456-0.424,1.456c-0.19,0-0.594-0.196-1.109-0.743c-1.058-1.138-2.891-1.036-3.821,0.205
								l-0.923,1.234c-0.4,0.526-0.975,0.522-1.368,0.003l-0.927-1.239C7.894,16.544,7.17,16.167,6.4,16.167
								c-0.685,0-1.336,0.294-1.832,0.827c-0.512,0.547-0.916,0.741-1.106,0.741c-0.172,0-0.428-0.464-0.428-1.461V5.953
								c0-3.263,0.491-3.795,3.502-3.795h6.93c1.54,0,2.387,0.189,2.828,0.632c0.469,0.471,0.668,1.416,0.664,3.163V16.285z"/>
								<path fill="#292D32" d="M6.43,8.483H6.422c-0.607,0-1.096,0.493-1.096,1.1c0,0.607,0.497,1.1,1.104,1.1s1.1-0.493,1.1-1.1
								C7.53,8.976,7.038,8.483,6.43,8.483z"/>
								<path fill="#292D32" d="M14.032,8.759H8.991c-0.455,0-0.825,0.37-0.825,0.825c0,0.455,0.37,0.825,0.825,0.825h5.041
								c0.455,0,0.825-0.37,0.825-0.825C14.857,9.128,14.487,8.759,14.032,8.759z"/>
								<path fill="#292D32" d="M6.43,4.817H6.422c-0.607,0-1.096,0.493-1.096,1.1s0.497,1.1,1.104,1.1s1.1-0.493,1.1-1.1
								S7.038,4.817,6.43,4.817z"/>
								<path fill="#292D32" d="M14.032,5.091H8.991c-0.455,0-0.825,0.37-0.825,0.825s0.37,0.825,0.825,0.825h5.041
								c0.455,0,0.825-0.37,0.825-0.825S14.487,5.091,14.032,5.091z"/>
							</g>
						</svg>
Subscriptions					</a>
				</li>
			</ul>
			<ul class="list-unstyled mb-0 mt-auto side_nav">
				<li>
					<a href="#.">
						<svg x="0px" y="0px" width="20px" height="20px" viewBox="1 1.5 20 20" enable-background="new 1 1.5 20 20" xml:space="preserve">
							<path fill="#71758E" d="M11,1.525c-5.508,0-9.975,4.466-9.975,9.975c0,5.508,4.466,9.975,9.975,9.975
							c5.508,0,9.975-4.466,9.975-9.975C20.975,5.992,16.508,1.525,11,1.525z M11,19.783c-4.573,0-8.283-3.709-8.283-8.283
							c0-4.573,3.709-8.283,8.283-8.283c4.573,0,8.283,3.709,8.283,8.283C19.283,16.073,15.573,19.783,11,19.783z"/>
							<path fill="#71758E" d="M13.485,7.152C12.817,6.566,11.935,6.245,11,6.245S9.183,6.568,8.515,7.152
							c-0.695,0.608-1.078,1.425-1.078,2.3v0.169c0,0.098,0.08,0.178,0.178,0.178h1.069c0.098,0,0.178-0.08,0.178-0.178V9.452
							C8.863,8.47,9.822,7.67,11,7.67c1.178,0,2.137,0.799,2.137,1.781c0,0.692-0.49,1.327-1.249,1.619
							c-0.472,0.18-0.873,0.497-1.16,0.911c-0.292,0.423-0.443,0.931-0.443,1.445v0.479c0,0.098,0.08,0.178,0.178,0.178h1.069
							c0.098,0,0.178-0.08,0.178-0.178v-0.505c0.001-0.216,0.067-0.427,0.19-0.605c0.123-0.178,0.296-0.315,0.498-0.393
							c1.314-0.505,2.162-1.663,2.162-2.95C14.562,8.577,14.18,7.759,13.485,7.152z M10.109,16.398c0,0.236,0.094,0.463,0.261,0.63
							c0.167,0.167,0.394,0.261,0.63,0.261s0.463-0.094,0.63-0.261c0.167-0.167,0.261-0.393,0.261-0.63c0-0.236-0.094-0.463-0.261-0.63
							c-0.167-0.167-0.394-0.261-0.63-0.261s-0.463,0.094-0.63,0.261C10.203,15.936,10.109,16.162,10.109,16.398z"/>
						</svg>
						Get Help
					</a>
				</li>
				<li>
					<a href="<?php echo website_url ?>settings.php">
						<svg x="0px" y="0px" width="20px" height="20px" viewBox="-1 -0.5 20 20" enable-background="new -1 -0.5 20 20" xml:space="preserve">
							<g>
								<path fill="#71758E" d="M9,19.479c-1.215,0-2.224-0.794-2.511-1.974c-0.034-0.141-0.101-0.273-0.194-0.381
								c-0.095-0.112-0.214-0.198-0.346-0.252C5.834,16.824,5.715,16.8,5.592,16.8c-0.212,0.014-0.354,0.061-0.479,0.136
								c-1.246,0.757-2.908,0.288-3.61-0.959c-0.456-0.813-0.434-1.782,0.06-2.592c0.075-0.123,0.121-0.265,0.132-0.41
								c0.011-0.142-0.012-0.288-0.068-0.421c-0.055-0.134-0.142-0.253-0.251-0.347c-0.112-0.095-0.243-0.162-0.382-0.197
								c-1.181-0.286-1.974-1.295-1.974-2.511c0-1.215,0.793-2.224,1.974-2.511c0.141-0.034,0.273-0.101,0.383-0.195
								C1.486,6.7,1.573,6.581,1.629,6.447c0.055-0.134,0.079-0.28,0.068-0.422C1.685,5.879,1.64,5.738,1.564,5.615
								c-0.494-0.81-0.516-1.78-0.06-2.592c0.702-1.249,2.362-1.719,3.612-0.96C5.571,2.34,6.315,2.213,6.489,1.494
								C6.776,0.314,7.785-0.479,9-0.479c1.215,0,2.224,0.793,2.51,1.974c0.035,0.14,0.102,0.272,0.196,0.382
								c0.094,0.11,0.213,0.197,0.347,0.252c0.114,0.047,0.232,0.071,0.352,0.071c0.217-0.014,0.357-0.06,0.48-0.134
								c1.251-0.763,2.908-0.29,3.612,0.958c0.456,0.812,0.434,1.781-0.06,2.592c-0.075,0.124-0.12,0.265-0.131,0.407
								c-0.012,0.146,0.012,0.292,0.067,0.427c0.054,0.132,0.142,0.251,0.251,0.345c0.11,0.095,0.239,0.161,0.381,0.195
								c1.18,0.287,1.974,1.296,1.974,2.511c0,1.215-0.794,2.225-1.974,2.511c-0.14,0.035-0.272,0.102-0.38,0.195
								c-0.113,0.096-0.199,0.214-0.253,0.347c-0.056,0.135-0.079,0.282-0.068,0.428c0.011,0.141,0.056,0.282,0.132,0.406
								c0.494,0.81,0.517,1.779,0.061,2.591c-0.703,1.248-2.364,1.722-3.611,0.96c-0.125-0.075-0.265-0.12-0.407-0.131
								c-0.198,0.01-0.313,0.021-0.426,0.067c-0.133,0.054-0.252,0.141-0.345,0.25c-0.096,0.113-0.162,0.24-0.197,0.382
								C11.224,18.686,10.215,19.479,9,19.479z M5.592,15.137c0.343,0,0.677,0.067,0.992,0.198c0.372,0.153,0.71,0.398,0.974,0.708
								c0.262,0.305,0.452,0.676,0.547,1.07C8.231,17.631,8.65,17.816,9,17.816c0.35,0,0.768-0.185,0.894-0.703
								c0.094-0.392,0.284-0.762,0.548-1.071c0.264-0.309,0.602-0.553,0.977-0.707c0.377-0.156,0.782-0.222,1.187-0.188
								c0.398,0.03,0.795,0.158,1.142,0.368c0.48,0.292,1.042,0.103,1.297-0.353c0.116-0.205,0.204-0.528-0.03-0.912
								c-0.21-0.347-0.338-0.742-0.37-1.145c-0.03-0.408,0.036-0.819,0.191-1.191c0.153-0.371,0.398-0.71,0.708-0.973
								c0.304-0.262,0.676-0.452,1.07-0.547c0.518-0.127,0.703-0.545,0.703-0.895c0-0.35-0.185-0.768-0.703-0.894
								C16.22,8.51,15.85,8.321,15.542,8.057c-0.309-0.264-0.553-0.602-0.707-0.975c-0.155-0.376-0.22-0.787-0.188-1.188
								c0.03-0.398,0.158-0.795,0.368-1.142c0.234-0.384,0.146-0.709,0.031-0.914c-0.258-0.456-0.823-0.644-1.297-0.353
								c-0.344,0.211-0.741,0.338-1.145,0.369c-0.4,0.035-0.81-0.032-1.188-0.189c-0.375-0.155-0.712-0.4-0.975-0.708
								C10.179,2.651,9.99,2.28,9.894,1.886C9.768,1.369,9.35,1.184,9,1.184c-0.35,0-0.769,0.185-0.894,0.703
								C7.822,3.05,6.789,3.862,5.593,3.862l0,0c-0.471,0-0.935-0.13-1.342-0.378c-0.477-0.29-1.04-0.103-1.297,0.353
								C2.839,4.042,2.752,4.366,2.985,4.75c0.211,0.346,0.338,0.742,0.369,1.146c0.032,0.402-0.034,0.813-0.189,1.188
								c-0.155,0.374-0.4,0.711-0.707,0.974C2.151,8.321,1.78,8.51,1.386,8.606C0.869,8.731,0.684,9.15,0.684,9.499
								c0,0.35,0.185,0.768,0.703,0.895c0.394,0.095,0.765,0.286,1.073,0.55c0.305,0.26,0.55,0.598,0.705,0.973
								c0.154,0.371,0.22,0.783,0.188,1.187c-0.032,0.404-0.159,0.799-0.369,1.145c-0.234,0.383-0.146,0.708-0.031,0.913
								c0.257,0.457,0.821,0.643,1.296,0.353c0.347-0.21,0.742-0.338,1.144-0.37C5.462,15.14,5.527,15.137,5.592,15.137z"/>
							</g>
							<g>
								<path fill="#71758E" d="M9,13.381c-2.14,0-3.881-1.741-3.881-3.881S6.86,5.619,9,5.619S12.881,7.36,12.881,9.5
								S11.14,13.381,9,13.381z M9,7.282c-1.223,0-2.218,0.995-2.218,2.218c0,1.223,0.995,2.218,2.218,2.218
								c1.223,0,2.218-0.995,2.218-2.218C11.218,8.277,10.223,7.282,9,7.282z"/>
							</g>
						</svg>
						Settings
					</a>
				</li>
			</ul>
		</div>
		<div class="dashboard_content w-100">
			<div class="pb-4 dashboard_content_head d-flex align-items-center justify-content-between">
				<input type="checkbox" class="openSidebarMenu d-none" id="openSidebarMenu">
				<label for="openSidebarMenu" class="sidebarIconToggle d-lg-none">
					<div class="spinner diagonal part-1"></div>
					<div class="spinner horizontal"></div>
					<div class="spinner diagonal part-2"></div>
				</label>

				<h1 class="mb-0 page_title flex-grow-1 ms-3 ms-lg-0">Dashboard</h1>

				<div class="dropdown user_nav_dropdown">
					<button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $_SESSION['user_first_name'] ?>
					</button>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
						<li><a class="dropdown-item" href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="dashboard_content_table mt-md-5 mt-4 p-4">
				<div class="d-flex mb-4 align-items-center justify-content-between">
					<h2 class="page_title mb-0">Donation List</h2>
					<a href="<?php echo website_url ?>donation-list.php" class="view_all_btn d-inline-flex align-items-center">
						View All
						<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6 12.5132L10 8.51318L6 4.51318" stroke="#1A202C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="table-responsive position-relative">
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>Program</th>
								<th>Email</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$query = "SELECT * FROM `transactions` WHERE `uid`='{$_SESSION['user_id']}'  and `type`='one-time' order by `timestamp`  DESC";
							$exicution = mysqli_query($con, $query) or die(mysqli_error($con) ."<br>". $query);
							if (mysqli_num_rows($exicution) < 1) { 
								echo( "No Records Found." ); 
							}
							$counter = 1;
							while ( $data = mysqli_fetch_array($exicution) ) {
								$src = '';
								// echo "<pre>"; print_r($data); die("</pre>");
								?>
								<tr>
									<td><b><?php echo $counter; $counter = $counter + 1; ?></b></td>
									<td>
										<div class="d-flex align-items-center text-wrap">
											<?php 
											if (isset($data['cause'])) {
												$cause_type = str_replace(' ', '', $data['cause']);
												$cause_type = strtolower($cause_type);
												if ($cause_type == 'orphansponsorship') {$src = 'img.png';}
												if ($cause_type == 'refugeesreliefs') {$src = 'img-1.png';}
												if ($cause_type == 'waterwells') {$src = 'img-2.png';}
												if ($cause_type == 'zakat') {$src = 'img-3.png';}
											}
											if (!isset($src) || empty($src)) {$src = 'img.png';}
											?>
											<img src="includes/images/<?php echo $src ?>" class='img-fluid me-2' alt="<?php echo $data['cause'] ?>">
											<b><?php echo $data['cause'] ?></b>
										</div>
									</td>
									<td><?php echo $data['email'] ?></td>
									<td>$<?php echo $data['amount'] ?></td>
									<td><?php echo $data['timestamp'] ?></td>
									<td>
										<!--	<div class="dropdown">
											<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
													Action
											</button>
											<ul class="dropdown-menu dropdown-menu-end action_btns" aria-labelledby="dropdownMenuButton1">
										
													<?php if ($data['refund'] != 'refund' ){ ?>
														<button data-cause='<?php echo $data['cause'] ?>' data-rf='<?php echo $data['trx_id'] ?>' type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
															Refund
														</button>
													<?php } else { ?>
														<a class="dropdown-item">
															<b>Refund Request Sent</b>
														</a>
													<?php } ?>
											> -->	</li>
											</ul>
										</div>
									</td>
								</tr>
								<?php
								echo "</tr>";
							}
							?>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Refund Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<input class="form-control" type="text" readonly disabled value="<?php echo $_SESSION['user_first_name'] ?>">
					</div>
					<div class="mb-3">
						<input class="form-control" type="email" readonly disabled value="<?php echo $_SESSION['user_email'] ?>">
					</div>
					<div class="mb-3">
						<input class="form-control form_cause" type="text" readonly disabled>
					</div>
					<div class="mb-3">
						<textarea class="form-control form_reason" placeholder="Why would you like to get a refund?"></textarea>
					</div>
				</div>
				<div class="modal-footer action_btns">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<a data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#thankyouModal" data-rf='' data-c='' class="btn theme_btn">Refund</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="thankyouModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="thankyouModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="thankyouModalLabel">ThankYou</h5>
				</div>
				<div class="modal-body">
					Your refund request has been send.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()" >Reload Page</button>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		function refreshPage() {
			location.reload();
		}
		$('.action_btns button').click(function(event) {
			var trx_rf = $(this).attr('data-rf');
			var trx_c = $(this).attr('data-c');
			var trx_cause =  $(this).attr('data-cause')
			if (typeof trx_rf !== 'undefined' && trx_rf !== false || typeof trx_c !== 'undefined' && trx_c !== false) {
				$('.action_btns a').attr('data-rf', trx_rf);
				$('.action_btns a').attr('data-c', trx_c);
				$('.form_cause').val(trx_cause);
			}
		});
		$('#openSidebarMenu').on('change', function(event) {
			event.preventDefault();
			if ($(this).is(':checked')) {
				$('body').addClass('active_menu');
			} else {
				$('body').removeClass('active_menu');
			}
		});
		$('.action_btns a').on('click', function(event) {
			event.preventDefault();
			var trx_rf = $(this).attr('data-rf');
			var trx_c = $(this).attr('data-c');
			if (typeof trx_rf !== 'undefined' && trx_rf !== false || typeof trx_c !== 'undefined' && trx_c !== false) {
				$('.table_loader').addClass('show');
				var trx_cause = $('.form_cause').val();
				var trx_reason = $('.form_reason').val();
				$.ajax({
					// url: '',
					method: "POST",
					data: {
						trx_rf: trx_rf,
						trx_c: trx_c,
						trx_cause: trx_cause,
						trx_reason: trx_reason
					},
					success: function (data) {

					}
				})
			}
		});
	</script>
</body>
</html>