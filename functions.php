<?php if(session_status()==PHP_SESSION_NONE){session_start();}

if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])) {

    $_SESSION['user_id']         = $_COOKIE['user_id'];

    $_SESSION['user_email']      = $_COOKIE['user_email'];

    $_SESSION['user_first_name'] = $_COOKIE['user_first_name'];

    $_SESSION['user_last_name']  = $_COOKIE['user_last_name'];

}

$test_mode=false;
define('website_url','https://handsforcharity.org/donate/');
$db="ahussein_devdonate";
$db_user="ahussein_goviral";
$db_pass="su1ep[sGd&Qh";
if($test_mode==true){
    $publish_key="pk_test_51KrzE2BwNF8aAhcXNMoFjTtRn2nyHynf61jKNUDmzmSQYNXQAQGPLFol3iNsKmB5VTnrZL1wvxQoXzhAqO5ygqGs00wJghjunP";
    $secret_key="sk_test_51KrzE2BwNF8aAhcXeLd3BzpavJHIGVxFgMIkK7lnsvdSDhaF4AtsoIcGeRV455YlKFrdjzUNdS5hVeW1sNE8ENes00N8VTmzJN";
    }else{
        $publish_key="pk_live_51KrzE2BwNF8aAhcXYHWtGJ2c96GwbiIckgl2TBv5z21R2Jt5kkSPObbx5zfCLVR079QjrSQJyA09pSSsGXWCw6Qr00kvn0wEy6";
        $secret_key="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";
        }
        if(isset($_SESSION['user_id'])){
            $user_login_status=true;
            $user_id=$_SESSION['user_id'];
            }else{
                $user_login_status=false;
                }
                $con=mysqli_connect("localhost",$db_user,$db_pass,$db)or die("Error ".mysqli_error($con));
                require_once 'includes/stripe-php/init.php';
                define('thankyou_url',website_url.'thankyou.php');
                \Stripe\Stripe::setApiKey($secret_key);
                $stripe=new \Stripe\StripeClient($secret_key);
                function updateTransactions(){
                    $query="SELECT * FROM `users`";global $con,$stripe;
                    $exicution=mysqli_query($con,$query)or die(mysqli_error($con)."<br>".$query);
                    if(mysqli_num_rows($exicution)<1){
                        die("No Records Found.");
                        }
                        $user_array=[];
                        while($data=mysqli_fetch_array($exicution)){
                            $user_array[$data['email']]['id']=$data['id'];
                            $user_array[$data['email']]['email']=$data['email'];
                            $user_array[$data['email']]['name']=$data['first_name'];
                            }
                            $i=$stripe->subscriptions->search(['limit'=>5,'query'=>'status:\'active\'',]);
                            foreach($i as $key=>$value){$invoice_data=$stripe->invoices->retrieve($value['latest_invoice'],[]);
                            $sub_id=$value['id'];
                            $pi_id=$invoice_data['payment_intent'];
                            $i_time=$invoice_data['created'];
                            $i_email=$invoice_data['customer_email'];
                            $i_time=date('Y-m-d H:i:s',$i_time);
                            $i_type=$invoice_data['description'];
                            $i_type=str_replace('Monthly - ','',$i_type);
                            $i_amount=$value['plan']['amount'];
                            $i_amount=$i_amount/100;
                            $i_canceled=$value['canceled_at'];
                            $query="SELECT * FROM `transactions` WHERE `trx_id`='{$pi_id}' limit 1";
                            $exicution=mysqli_query($con,$query)or die(mysqli_error($con)."<br>".$query);
                            if(mysqli_num_rows($exicution)<1){
                                $u_id=$user_array[$i_email]['id'];
                                $u_email=$user_array[$i_email]['email'];
                                $u_name=$user_array[$i_email]['name'];
                                $query_insert="INSERT INTO `transactions`

            (`uid`, `name`, `email`, `cause`, `type`, `amount`, `timestamp`, `trx_id`, `sub_id`) 

            VALUES 

            ('{$u_id}', '{$u_name}', '{$u_email}', '{$i_type}', 'monthly', '{$i_amount}', '{$i_time}', '{$pi_id}', '{$sub_id}')";

            $result=mysqli_query($con,$query_insert);
            if($result){

            }else{

            }
        }else{

        }
    }
}
function password_generate($chars){
    $data='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($data),0,$chars);
}
function udpateRefunds(){
    global $con,$stripe;
    $refund=$stripe->refunds->all(['limit'=>5]);
    foreach($refund['data']as $key=>$value){
        if(isset($value['payment_intent'])&&!empty($value['payment_intent'])){$payment_id=$value['payment_intent'];
        $query="SELECT * FROM `transactions` WHERE `trx_id`='{$payment_id}'";
    }else{
        $payment_id=$value['charge'];
    }
    $refund_id=$value['id'];
    $update_query="UPDATE `transactions` SET `refund`='refund', `refund_id`='{$refund_id}' WHERE `trx_id`='{$payment_id}';";
    $result=mysqli_query($con,$update_query);
    if($result){

    }else{

    }
}
}updateTransactions();
udpateRefunds();


\Stripe\ApplePayDomain::create([
    'domain_name' => 'https://handsforcharity.org',
]);

if(isset($_POST['p_opts'])){

} 

           if (isset($_POST['cp']) && $_POST['cp'] == 'true') {
               session_destroy();
               session_start();
    if (isset($_POST['i_type']) && isset($_POST['payment']) && isset($_POST['g_opts'])) {
        $_SESSION['i_type'][0] = $_POST['i_type'];
        $_SESSION['cause'][$_POST['i_type']] = $_POST['payment'];
        if (isset($_POST['cst_amount']) && !empty($_POST['cst_amount'])) {
            $_SESSION['payment'] = $_POST['cst_amount'];
        } else {
            $_SESSION['payment'] = $_POST['payment'];
        }
        $_SESSION['g_opts'] = $_POST['g_opts'];
        header('Location: '.website_url.'checkout.php');
        die();
    } else {
        header('Location: '.website_url);
        die();
    }
}
           ?>