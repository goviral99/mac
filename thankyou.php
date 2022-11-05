<?php
include_once('functions.php');
if (isset($_GET['trxn_id']) && !empty($_GET['trxn_id'])) {
    $_SESSION['trans_id'] = $_GET['trxn_id'];
}
if (!isset($_SESSION['trans_id'])) {
    header('Location:' . website_url);
    exit;
}

$frequency = '';
if ($_SESSION['g_opts'] == 0) {
    $frequency = 'One-Time';
}
if ($_SESSION['g_opts'] == 1) {
    $frequency = 'Monthly';
}
if ($_SESSION['g_opts'] == 2) {
    $frequency = 'Yearly';
}

if (isset($_GET['paypal_subs']) && !empty($_GET['paypal_subs'])) {
    $email = $_SESSION['co_email'];
    $cause = $_SESSION['cause'];


    $password = password_generate(8) . uniqid();
    $to = $email;
    $subject = "New User Registerd";

    $message = "
    <html>
        <head>
            <title>New User Registerd</title>
        </head>
        <body>
            <p>Your Account has been registered please Login by going to https://handsforcharity.org/donate/login.php</a></p>
            <table>
                <tr>
                    <th>User: $email</th>
                </tr>
                <tr>
                    <td>Password: $password</td>
                </tr>
            </table>
        </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: noreply@handsforcharity.org';


    $query = "SELECT * FROM `users` WHERE `email`='{$email}'";
    $exicution = mysqli_query($con, $query) or die(mysqli_error($con) . "<br>" . $query);
    if (mysqli_num_rows($exicution) < 1) {
        $query_insert = "INSERT INTO `users`(`email`,`first_name`,`password`) VALUES ('{$email}','{$name}','{$password}')";
        $result = mysqli_query($con, $query_insert);
        if ($result) {
            $insert_user_id = mysqli_insert_id($con);
            mail($to, $subject, $message, $headers);
        }
    } else {
        while ($data = mysqli_fetch_array($exicution)) {
            $insert_user_id = $data['id'];
        }
        $_SESSION['email_exist'] = true;
    }

    $query_insert = "INSERT INTO `transactions`
    (`uid`, `name`, `email`, `cause`, `type`, `amount`, `timestamp`, `trx_id`, `sub_id`) 
    VALUES 
    ('{$insert_user_id}', '{$name}', '{$email}', '{$cause}', '{$interval}', '{$i_amount}', '{$i_time}', '{$pi_id}', '{$sub_id}')
    ";
    $result = mysqli_query($con, $query_insert);
    if ($result) {
        $orderStatus = 'scceessed';
        header('Location:' . thankyou_url);
        exit;
    } else {
        echo "<pre>";
        print_r($query_insert . mysqli_error($con));
        die("</pre>");
    }


}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="includes/images/Logo.png">
        <title></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="d-flex align-items-center py-5 py-md-4" style="min-height: 100vh">
            <?php
            $to = $_SESSION['co_email'];
            $subject = "Donation Successful";
            ?>
            <?php ob_start(); ?>
            <table class="w-100" cellpadding="0" cellspacing="0" cols="1" bgcolor="#d7d7d7" align="center" style="max-width: 600px;">
                <tbody><tr bgcolor="#d7d7d7">
                        <td height="50" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                    </tr>

                    <!-- This encapsulation is required to ensure correct rendering on Windows 10 Mail app. -->
                    <tr bgcolor="#d7d7d7">
                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                            <!-- Seperator Start -->
                            <table cellpadding="0" cellspacing="0" cols="1" bgcolor="#d7d7d7" align="center" style="max-width: 600px; width: 100%;">
                                <tbody><tr bgcolor="#d7d7d7">
                                        <td height="30" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                </tbody></table>
                            <!-- Seperator End -->

                            <!-- Generic Pod Left Aligned with Price breakdown Start -->
                            <table align="center" cellpadding="0" cellspacing="0" cols="3" bgcolor="white" class="bordered-left-right" style="border-left: 10px solid #d7d7d7; border-right: 10px solid #d7d7d7; max-width: 600px; width: 100%;">
                                <tbody><tr height="50"><td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                                    <tr align="center">
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td class="text-primary" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                        </td>
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                    <tr height="17"><td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                                    <tr align="center">
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td class="text-primary" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                            <h1 style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 34px; margin-bottom: 0; margin-top: 0;">Donation Successful</h1>
                                        </td>
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                    <tr height="30"><td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                                    <tr align="left">
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                            <p style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                                Hi <?php echo $_SESSION['user_name'] ?>, 
                                            </p>
                                        </td>
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                    <tr height="10"><td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                                    <tr align="left">
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                            <p style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">Your transaction was successful!</p>
                                            <br>
                                            <p style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0; "><strong>Payment Details:</strong><br>
                                            	<table style="width: 100%; border:0">
                                            		<tbody>
                                            			<tr>
                                            				<th align="left">
                                            					Cause
                                            				</th>
                                            				<th align="left">
                                            					Amount
                                            				</th>
                                            			</tr>
                                            			<?php 
                                            			foreach ($_SESSION['cause'] as $key => $value): ?>
                                            				<tr>
                                            					<td align="left">
                                            						<?php echo $key ?>
                                            					</td>
                                            					<td align="left">
                                            						$<?php echo $value ?>
                                            					</td>
                                            				</tr>
                                            			<?php endforeach ?>
                                                        <?php if (isset($_SESSION['process_fee']) && $_SESSION['process_fee'] > 0): ?>
                                                            <tr>
                                                                <td align="left">
                                                                    Process Fee
                                                                </td>
                                                                <td align="left">
                                                                    $<?php echo $_SESSION['process_fee'] ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif ?>
                                                        <?php if (isset($_SESSION['extra_gift'])): ?>
                                                            <tr>
                                                                <td>Gift</td>
                                                                <td>$<?php echo $_SESSION['extra_gift'] ?></td>
                                                            </tr>
                                                        <?php endif ?>
                                                        <tr>
                                                            <td align="left">
                                                                <br>
                                                                <b>Plan Type</b>
                                                            </td>
                                                            <td align="left">
                                                                <br>
                                                                <?php echo $frequency; ?>
                                                            </td>
                                                        </tr>
                                            		</tbody>
                                            	</table>
                                            </p>
                                            <br>
                                            <p style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">We advise to keep this email for future reference.&nbsp;&nbsp;&nbsp;&nbsp;<br></p>
                                            <?php if (isset($_SESSION['email_exist']) && $_SESSION['email_exist'] == true) { ?>
                                                <p>Login to see you donation. <a href="<?php echo website_url ?>/login.php">Click here</a></p>
                                            <?php } else { ?>
                                                <p>
                                                	<br>
                                                	Your account is registered and an email has been send at <b><?php echo $_SESSION['co_email'] ?></b>.
                                                	<br>
                                                	Login to see your donation. <a href="<?php echo website_url ?>/login.php">Click here</a>
                                                </p>
                                            <?php } ?>
                                        </td>
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                    <tr height="30">
                                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td style="border-bottom: 1px solid #D3D1D1; color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                    <tr height="30"><td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                                    <tr align="center">
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                        <td style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                            <p style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;"><strong>Transaction reference: <?php echo $_SESSION['trans_id'] ?></strong></p>
                                        </td>
                                        <td width="36" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>

                                    <tr height="50">
                                        <td colspan="3" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>

                                </tbody></table>
                            <!-- Generic Pod Left Aligned with Price breakdown End -->

                            <!-- Seperator Start -->
                            <table cellpadding="0" cellspacing="0" cols="1" bgcolor="#d7d7d7" align="center" style="max-width: 600px; width: 100%;">
                                <tbody><tr bgcolor="#d7d7d7">
                                        <td height="50" style="color: #121942; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                                    </tr>
                                </tbody></table>
                            <!-- Seperator End -->

                        </td>
                    </tr>
                </tbody></table>
            <?php
            $message = ob_get_clean();
            echo $message;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: noreply@handsforcharity.org';
            mail($to, $subject, $message, $headers);
             if (!isset($_SESSION['user_id'])) {
                session_destroy();
             }
            ?>
            <meta http-equiv="refresh" content="5;url=http://handsforcharity.org/" />

        </div>
    </body>
</html>