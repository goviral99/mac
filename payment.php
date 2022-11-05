<?php

include_once('functions.php');

$_SESSION['first_name']    = $_POST['co_fname'];
$_SESSION['info_lastname'] = $_POST['co_lname'];
$_SESSION['info_email']    = $_POST['co_email'];
$_SESSION['info_phone']    = $_POST['co_phone'];
$_SESSION['info_org']      = $_POST['co_org'];
$_SESSION['info_zip']      = $_POST['co_zip'];

$_SESSION['country'] = $_POST['co_country'];
$_SESSION['address1'] = $_POST['co_address1'];
$_SESSION['address2'] = $_POST['co_address2'];
$_SESSION['city'] = $_POST['co_city'];
$_SESSION['state'] = $_POST['co_state'];

$info_country  = $_SESSION['country'];
$info_address1 = $_SESSION['address1'];
$info_address2 = $_SESSION['address2'];
$info_city     = $_SESSION['city'];
$info_state    = $_SESSION['state']; 

$info_lastname = $_SESSION['info_lastname'];
$info_phone    = $_SESSION['info_phone'];
$info_org      = $_SESSION['info_org'];
$info_zip      = $_SESSION['info_zip'];

if (isset($_POST['p_type']) && $_POST['p_type'] == 'pp') {
    
    $name = $_POST['co_fname'];
    $email = $_POST['co_email'];
    $_SESSION['total_payment'] = $_POST['total_payment'];
    $counter = 1;
    
    // $paypal_process_fee = 0;
    if (isset($_POST['app_fee']) && $_POST['app_fee'] == 1) {
        $paypal_process_fee = ($_SESSION['payment'] / 100) * 2.2;
        $paypal_process_fee = ceil($paypal_process_fee + 0.30);
        $_SESSION['process_fee'] = $paypal_process_fee;
    }
    
    if (isset($_POST['extra_gift'])) {
        $_SESSION['extra_gift'] = $_POST['extra_gift'];
    }
    $_SESSION['user_name'] = $_POST['co_fname'];
    $_SESSION['co_email'] = $_POST['co_email'];
    header('Location:' . website_url.'paypal.php');
    exit;
} else {

    if (!empty($_POST['stripeToken'])) {

        $token = $_POST['stripeToken'];

        $name = $_POST['co_fname'];

        $email = $_POST['co_email'];

        $_SESSION['co_email'] = $email;

        $amount = $_POST['total_payment'];

        $cause = '';



        $counter = 1;

        foreach ($_SESSION['cause'] as $key => $value) {

            $key = str_replace(' ', '', $key);

            $cause = $cause.$key;

            if ($counter < count($_SESSION['cause'])) {

                $cause = $cause.'_';

            }

            $counter = $counter + 1;

        }

        if (isset($_POST['extra_gift'])) {

            $_SESSION['extra_gift'] = $_POST['extra_gift'];

        }

        



        $password = password_generate(8) . uniqid();

        $to = $email;

        $subject = "New User Registerd";



        $message = "

        <html>

            <head>

                <title>New User Registerd</title>

            </head>

            <body>

                <p>Your Account has been registered please <a href='pksole.com/hfc/login.php'>Login</a></p>

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



        if (isset($_POST['extra_gift'])) {

            $amount = $amount + 10;

        }



        try {

            $customer = \Stripe\Customer::create(array(

                        'email' => $email,
                        // 'source' => 'tok_visa',
                        'source' => $token,

            ));

        } catch (Exception $e) {

            $api_error = $e->getMessage();

        }



        $amount_fee = 0;

        if (isset($_POST['app_fee']) && $_POST['app_fee'] == 1) {
            $amount_fee = ($_SESSION['payment'] / 100) * 2.2;
            $amount_fee = ceil($amount_fee + 0.30);
            $_SESSION['process_fee'] = $amount_fee;
        }        



        if (empty($api_error) && $customer) {

            $itemPriceCents = ($amount * 100);

            $test_mode = true;

            if ($_SERVER['SERVER_NAME'] === "localhost" || $test_mode == true) {

                // $acc_id = 'acct_1LHnTRCDNhKBnSZL';

                $acc_id = 'acct_1KrzE2BwNF8aAhcX';

            } else {

                $acc_id = 'acct_1KrzE2BwNF8aAhcX';

            }

            try {

                if ($_SESSION['g_opts'] == 1 || $_SESSION['g_opts'] == 2) {

                    if ($_SESSION['g_opts'] == 1) {

                        $interval = 'monthly';

                        $p_name = 'm_dn_' . $cause . '_' . $amount;

                    }

                    if ($_SESSION['g_opts'] == 2) {

                        $interval = 'yearly';

                        $p_name = 'y_dn_' . $cause . '_' . $amount;

                    }

                    $p_name = str_replace(' ', '', $p_name);





                    $query = "SELECT * FROM `created_products` WHERE `name`='{$p_name}'";

                    $exicution = mysqli_query($con, $query) or die(mysqli_error($con) . "<br>" . $query);

                    if (mysqli_num_rows($exicution) < 1) {

                        if ($_SESSION['g_opts'] == 1) {

                            $create_product = $stripe->products->create(

                                [

                                    'name' => $p_name,

                                    'default_price_data' => [

                                        'unit_amount' => $itemPriceCents,

                                        'currency' => 'cad',

                                        'recurring' => ['interval' => 'month'],

                                    ],

                                // 'expand' => ['default_price'],

                                ]

                            );             

                        }

                        if ($_SESSION['g_opts'] == 2) {

                            $create_product = $stripe->products->create(

                                [

                                    'name' => $p_name,

                                    'default_price_data' => [

                                        'unit_amount' => $itemPriceCents,

                                        'currency' => 'cad',

                                        'recurring' => ['interval' => 'year'],

                                    ],

                                // 'expand' => ['default_price'],

                                ]

                            );                   

                        }

                        

                        $created_productd_id = $create_product['default_price'];

                        $query_insert = "INSERT INTO `created_products`(`name`, `price_id`) VALUES ('{$p_name}', '{$created_productd_id}')";

                        $result = mysqli_query($con, $query_insert);

                        if ($result) {

                            

                        } else {

                            echo "<pre>";

                            print_r($query_insert . mysqli_error($con));

                            die("</pre>");

                        }

                    } else {

                        while ($data = mysqli_fetch_array($exicution)) {

                            $created_productd_id = $data['price_id'];

                        }

                    }

                    

                    if ($_SESSION['g_opts'] == 1) {

                        $charge = $stripe->subscriptions->create([

                            'customer' => $customer->id,

                            'description' => 'Monthly - ' . $cause,

                            'items' => [

                                ['price' => $created_productd_id],

                            ],
                            "metadata" => [
                                'FirstName'    => $_SESSION['first_name'],
                                'LastName'     => $_SESSION['info_lastname'],
                                'Email'        => $_SESSION['info_email'],
                                'Phone'        => $_SESSION['info_phone'],
                                'Organisation' => $_SESSION['info_org'],
                                'Address1'     => $_SESSION['address1'],
                                'Address2'     => $_SESSION['address2'],
                                'Country'      => $_SESSION['country'],
                                'City'         => $_SESSION['city'],
                                'State'        => $_SESSION['state'],
                                'PostalCode'   => $_SESSION['info_zip']
                            ]

                        ]);                     

                    }

                    if ($_SESSION['g_opts'] == 2) {

                        $charge = $stripe->subscriptions->create([

                            'customer' => $customer->id,

                            'description' => 'Yearly - ' . $cause,

                            'items' => [

                                ['price' => $created_productd_id],

                            ],
                            "metadata" => [
                                'FirstName'    => $_SESSION['first_name'],
                                'LastName'     => $_SESSION['info_lastname'],
                                'Email'        => $_SESSION['info_email'],
                                'Phone'        => $_SESSION['info_phone'],
                                'Organisation' => $_SESSION['info_org'],
                                'Address1'     => $_SESSION['address1'],
                                'Address2'     => $_SESSION['address2'],
                                'Country'      => $_SESSION['country'],
                                'City'         => $_SESSION['city'],
                                'State'        => $_SESSION['state'],
                                'PostalCode'   => $_SESSION['info_zip']
                            ]

                        ]);                     

                    }

                } else {

                    $charge = \Stripe\Charge::create(array(

                        'customer' => $customer->id,

                        'amount' => $itemPriceCents,

                                // 'currency'    => 'usd',

                        'currency' => 'cad',

                        'description' => $cause,
                        "metadata" => [
                                'FirstName'    => $_SESSION['first_name'],
                                'LastName'     => $_SESSION['info_lastname'],
                                'Email'        => $_SESSION['info_email'],
                                'Phone'        => $_SESSION['info_phone'],
                                'Organisation' => $_SESSION['info_org'],
                                'Address1'     => $_SESSION['address1'],
                                'Address2'     => $_SESSION['address2'],
                                'Country'      => $_SESSION['country'],
                                'City'         => $_SESSION['city'],
                                'State'        => $_SESSION['state'],
                                'PostalCode'   => $_SESSION['info_zip']
                            ]

                    ), array('stripe_account' => $acc_id));

                }                

            } catch (Exception $e) {

                $api_error = $e->getMessage();

            }

            



            if (empty($api_error) && $charge) {    



                $chargeJson = $charge->jsonSerialize();

                



                if (($_SESSION['g_opts'] == 1 || $_SESSION['g_opts'] == 2) && (isset($chargeJson['status']) && $chargeJson['status'] == 'active')) {



                    $payment_status = $chargeJson['status'];

                    $sub_id = $chargeJson['id'];

                    $frequency = 'monthly';

                    $trans_invoice = $chargeJson['latest_invoice'];

                    $i_amount = $chargeJson['plan']['amount'];

                    $i_amount = ($i_amount / 100);

                    $i_type = $chargeJson['description'];

                    $i_type = str_replace('Monthly - ', '', $i_type);

                    $i_type = str_replace('Yearly - ', '', $i_type);

                    $invoice_data = $stripe->invoices->retrieve(

                            $trans_invoice, []

                    );

                    

                    $pi_id  = $invoice_data['payment_intent'];

                    $i_time = $invoice_data['created'];

                    $i_time = date('Y-m-d H:i:s' , $i_time);



                    $_SESSION['user_name'] = $name;

                    $_SESSION['trans_id'] = $sub_id;

                    $_SESSION['paid_amount'] = $i_amount;

                    $_SESSION['payment_status'] = $payment_status;



                    //Comment Area

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

                    (`uid`, `name`, `email`, `cause`, `type`, `amount`, `timestamp`, `trx_id`, `sub_id`, `country`, `address1`, `address2`, `city`, `state`, `last_name`, `phone`, `organisation`, `zip_code`) 

                    VALUES 

                    ('{$insert_user_id}', '{$name}', '{$email}', '{$cause}', '{$interval}', '{$i_amount}', '{$i_time}', '{$pi_id}', '{$sub_id}', '{$info_country}', '{$info_address1}', '{$info_address2}', '{$info_city}', '{$info_state}', '{$info_lastname}', '{$info_phone}', '{$info_org}', '{$info_zip}')

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



                } elseif ($_SESSION['g_opts'] == 0 && ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)) {



                    $payment_status = $chargeJson['status'];

                    $trans_id = $chargeJson['id'];

                    $paid_amount = $chargeJson['amount'];

                    $paid_amount = ($paid_amount / 100);

                    $frequency = 'one-time';



                    $_SESSION['user_name'] = $name;

                    $_SESSION['trans_id'] = $trans_id;

                    $_SESSION['paid_amount'] = $paid_amount;

                    $_SESSION['payment_status'] = $payment_status;



                    //Comment Area

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





                    $i_time = strtotime('now');

                    $i_time = date('Y-m-d H:i:s' , $i_time);



                    $query_insert = "INSERT INTO `transactions`(`uid`,`name`,`email`,`cause`,`type`,`amount`,`timestamp`,`trx_id`, `country`, `address1`, `address2`, `city`, `state`, `last_name`, `phone`, `organisation`, `zip_code`) VALUES ('{$insert_user_id}','{$name}','{$email}','{$cause}','{$frequency}','{$paid_amount}','{$i_time}','{$trans_id}', '{$info_country}', '{$info_address1}', '{$info_address2}', '{$info_city}', '{$info_state}', '{$info_lastname}', '{$info_phone}', '{$info_org}', '{$info_zip}')";

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

                } else {

                    $statusMsg = 'Transaction has been failed!';

                }

            } else {

                $statusMsg = 'Charge creation failed!' . $api_error;

            }

        } else {

            $statusMsg = 'Invalid card details ' . $api_error;

        }

        if (!empty($statusMsg)) {

            $_SESSION['statusMsg'] = $statusMsg;

            header('Location:' . website_url . '/checkout.php');

            die();

        }

    } else {

        header('Location:' . thankyou_url);

        exit;

    }

    }

?>