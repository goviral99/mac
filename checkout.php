<?php
include_once('functions.php');

if (isset($_POST['i_type'])) {
    $cause_array = array('Orphan Sponsorship', 'Refugees Reliefs', 'Water Wells', 'Zakat');
    // if (in_array($_SESSION['cause'], $cause_array)) {
    // } else {
    //     $_SESSION['statusMsg'] = 'Select Donate Cause';
    //     header('Location: '.website_url);
    // die();
    // }
    
    
    if (!function_exists('str_contains')) {
        function str_contains(string $haystack, string $needle): bool
        {
            return '' === $needle || false !== strpos($haystack, $needle);
        }
    }

    $_SESSION['i_type'] = $_POST['i_type'];

    $total_amount =  0;
    foreach ($_POST['i_type'] as $key => $value) {
        $v = str_replace(' ', '_', $value);
        if (!empty($_POST[$v][1])) {
            if (str_contains($_POST[$v][1], 'Orphan') || str_contains($value, 'Orphan')) {
                $_POST[$v][1] = str_replace('Orphans', '', $_POST[$v][1]);
                $_POST[$v][1] = str_replace('Orphan', '', $_POST[$v][1]);
                if ($_POST['g_opts'] == 0 || $_POST['g_opts'] == 2) {
                    $_POST[$v][1] = (int)$_POST[$v][1];
                    $_POST[$v][1]= $_POST[$v][1] * 840;
                    $_POST[$v][1] = (int)$_POST[$v][1];
                }
                if ($_POST['g_opts'] == 1) {
                    $_POST[$v][1] = (int)$_POST[$v][1];
                    $_POST[$v][1]= $_POST[$v][1] * 70;
                    $_POST[$v][1] = (int)$_POST[$v][1];
                }
            }
            $total_amount =  $total_amount + $_POST[$v][1];
            $_SESSION['cause'][$value] = $_POST[$v][1];
        } else {
            if (str_contains($_POST[$v][0], 'Orphan')) {
                $_POST[$v][0] = str_replace('Orphans', '', $_POST[$v][0]);
                $_POST[$v][0] = str_replace('Orphan', '', $_POST[$v][0]);
                if ($_POST['g_opts'] == 0 || $_POST['g_opts'] == 2) {
                    $_POST[$v][0] = (int)$_POST[$v][0];
                    $_POST[$v][0] = $_POST[$v][0] * 840;
                    $_POST[$v][0] = (int)$_POST[$v][0];
                }
                if ($_POST['g_opts'] == 1) {
                    $_POST[$v][0] = (int)$_POST[$v][0];
                    $_POST[$v][0] = $_POST[$v][0] * 70;
                    $_POST[$v][0] = (int)$_POST[$v][0];
                }
            }            
            $total_amount =  $total_amount + $_POST[$v][0];
            $_SESSION['cause'][$value] = $_POST[$v][0];
        }  
    }
    
    $_SESSION['payment'] = $total_amount;
    $_SESSION['g_opts'] = $_POST['g_opts'];
    // if ($_POST['p_opts'] == 0) {
    //     $_SESSION['payment'] = $_POST['p_opts_other'];
    // } else {
    //     $_SESSION['payment'] = $_POST['p_opts'];
    // }    
} elseif (isset($_SESSION['payment'])) {
    
} else {
    session_destroy();
    header('Location: '.website_url);
    die();
}

if ($_SESSION['payment'] == 0) {
    $_SESSION['statusMsg'] = 'Please select amount for donation';
    header('Location: '.website_url);
    die();
}

$frequency = '';
if ($_SESSION['g_opts'] == 0) {
    $frequency = 'one-time';
}
if ($_SESSION['g_opts'] == 1) {
    $frequency = 'monthly';
}
if ($_SESSION['g_opts'] == 2) {
    $frequency = 'yearly';
}
// echo "<pre>"; print_r($_POST['i_type']); die("</pre>");

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
        <style type="text/css">
            input.field_error {
                border-color: red !important;
            }
        </style>
        
               <footer class="py-5 py-md-4">
            <div class="container">
                <div class="d-md-flex justify-content-between align-items-center">
                    <a href="http://handsforcharity.org/">
                        <img src="includes/images/Logo.png" class="img-fluid" alt="logo">
                    </a>
                    <ul class="list-unstyled mt-3 mt-md-0 mb-0 footer_social_icons d-flex align-items-center">
                        <li>
                            <a href="https://www.linkedin.com/company/hands4charity/" class="d-flex align-items-center justify-content-center">
                               <svg fill="#1f92c8" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="60px" height="60px">    <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M10.496,8.403 c0.842,0,1.403,0.561,1.403,1.309c0,0.748-0.561,1.309-1.496,1.309C9.561,11.022,9,10.46,9,9.712C9,8.964,9.561,8.403,10.496,8.403z M12,20H9v-8h3V20z M22,20h-2.824v-4.372c0-1.209-0.753-1.488-1.035-1.488s-1.224,0.186-1.224,1.488c0,0.186,0,4.372,0,4.372H14v-8 h2.918v1.116C17.294,12.465,18.047,12,19.459,12C20.871,12,22,13.116,22,15.628V20z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/hands4charity" class="d-flex align-items-center justify-content-center">
                                <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.4 23V14.4H1V9.5H3.4V7.1C3.4 3.7 6.1 1 9.5 1H13.2V5.9H10.8C9.4 5.9 8.4 7 8.4 8.3V9.5H13.3L12 14.4H8.3V23H3.4Z" fill="#0092C8" stroke="#0092C8" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/channel/UCqXuNEB0D9mYdGrhgb_gE2Q" class="d-flex align-items-center justify-content-center">
                                <svg  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                      width="27px" height="20px" viewBox="0 0 27 20" enable-background="new 0 0 27 20" xml:space="preserve">
                                <path fill="#0092C8" d="M12.209,0h1.996h0.822C25.122,0.118,26.883,1.657,27,9.112v0.828v0.947C26.883,18.698,25.004,20,13.735,20
                                      h-1.644h-1.174C1.643,19.882,0.117,18.225,0,10.533V9.586V8.994C0.235,1.42,2.113,0.118,12.209,0z M11.27,6.509v7.101l5.869-3.55
                                      L11.27,6.509z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/hands4charity/" class="d-flex align-items-center justify-content-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 0.5C21.5 0.5 23.5 2.5 23.5 5V19C23.5 21.5 21.5 23.5 19 23.5H5C2.5 23.5 0.5 21.5 0.5 19V5C0.5 2.5 2.5 0.5 5 0.5H19ZM12 5.8C8.5 5.8 5.8 8.6 5.8 12C5.8 15.5 8.6 18.2 12 18.2C15.5 18.2 18.2 15.4 18.2 12C18.2 8.5 15.5 5.8 12 5.8ZM12 7.2C14.6 7.2 16.8 9.3 16.8 12C16.8 14.6 14.7 16.8 12 16.8C9.4 16.8 7.2 14.7 7.2 12C7.2 9.4 9.4 7.2 12 7.2ZM19 3.5C18.2 3.5 17.5 4.2 17.5 5C17.5 5.8 18.2 6.5 19 6.5C19.8 6.5 20.5 5.8 20.5 5C20.5 4.2 19.8 3.5 19 3.5Z" fill="#0092C8"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>

        <div class="container py-4 pt-md-5 w-100">
            <div class="row">
                <div class="col-md-8 checkout_form">
                    
                    <h1 class="mainTitle mt-3 mb-2 text-center">$<?php echo $_SESSION['payment'] ?> (<?php echo $frequency ?>)</h1>
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <p class="text-center">
                                Thank you for your generosity. 
                            </p>
                        </div>
                    </div>
                </div>
                <?php if (!empty($_SESSION['statusMsg'])) {
                    ?>
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="24px" height="24px" viewBox="-3.994 -4 24 24" enable-background="new -3.994 -4 24 24" xml:space="preserve">
                            <path fill="#664D03" d="M8,19.942c6.595,0,11.942-5.347,11.942-11.942S14.595-3.942,8-3.942S-3.942,1.405-3.942,8
                            S1.405,19.942,8,19.942z M9.388,5.892l-1.493,7.023c-0.104,0.508,0.043,0.796,0.454,0.796c0.29,0,0.727-0.104,1.024-0.367
                            l-0.131,0.621c-0.428,0.516-1.373,0.893-2.187,0.893c-1.049,0-1.496-0.63-1.206-1.969l1.102-5.177
                            C7.046,7.275,6.96,7.116,6.522,7.01L5.849,6.889l0.122-0.569L9.39,5.892L9.388,5.892z M8,4.268c-0.824,0-1.493-0.668-1.493-1.493
                            S7.176,1.283,8,1.283s1.493,0.668,1.493,1.493S8.824,4.268,8,4.268z"/>
                        </svg>
                            <?php echo $_SESSION['statusMsg'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php
                    $_SESSION['statusMsg'] = '';
                } ?>
                <div class="col-md-8 checkout_form">
                    <form action="payment.php" method="post" id="payment_form">
                        <h5 class="mb-3"><b>Payment Method</b></h5>
                        <nav>
                            <div class="nav nav-tabs row payment_tabs mb-4" id="nav-tab" role="tablist">
                                <button class="col-md mb-3 mb-md-0 nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                    <div class="i_input_inner">
                                        <input id="i_type1" type="radio" name="p_type" value="cc" checked>
                                        <label for="i_type1" class="d-flex p-2 align-items-center" data-img-url="includes/images/img1.jpg">
                                            Credit Card
                                        </label>
                                    </div>
                                </button>

                                <?php if ($_SESSION['g_opts'] == 0 ): ?>
                                <button class="col-md mb-3 mb-md-0 nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <div class="i_input_inner">
                                        <input id="i_type2" type="radio" name="p_type" value="gp">
                                        <label for="i_type2" class="d-flex p-2 align-items-center" data-img-url="includes/images/img2.jpg">
                                            Google/Apple Pay
                                        </label>
                                    </div>
                                </button>
                                <?php endif ?>


                                <button class="col-md nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                                    <div class="i_input_inner">
                                        <input id="i_type3" type="radio" name="p_type" value="pp">
                                        <label for="i_type3" class="d-flex p-2 align-items-center" data-img-url="includes/images/img3.jpg">
                                            PayPal
                                        </label>
                                    </div>
                                </button>

                            </div>
                        </nav>
                    
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <h5 class="mb-3"><b>Credit Card Information</b></h5>
                                <div class="row mb-3 mb-md-4">
                                    <div class="form-group col-md-12 mb-3 mb-md-4">
                                        <div class="position-relative">
                                            <img src="includes/images/frame.png" class="img-fluid" alt="">
                                            <input type="text" class="form-control" name="co_chn" placeholder="Card Holder Name">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 mb-3 mb-md-4">
                                        <div class="position-relative">
                                            <img src="includes/images/cards.png" class="img-fluid" alt="">
                                            <div id="co_cn" ></div>
                                        </div>
                                        <div id="co_cn_response"></div>
                                        <!-- <input type="text" class="form-control" name="co_cn" placeholder="Card number"> -->
                                    </div>
                                    <div class="form-group col-md-4 mb-3 mb-md-4">
                                        <div class="position-relative">
                                            <img src="includes/images/stickynote.png" class="img-fluid" alt="">
                                            <div id="co_my"></div>
                                        </div>
                                        <div id="co_my_response"></div>
                                    </div>
                                    <div class="form-group col-md-3 mb-3 mb-md-4">
                                        <div class="position-relative">
                                            <img src="includes/images/key.png" class="img-fluid" alt="">
                                            <div id="co_cw"></div>
                                        </div>
                                        <div id="co_cw_response"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <div id="payment-request-button">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">

                            </div>
                        </div>
                        <div class="checkout_form_details">
                            <h5 class="mb-3"><b>Your Details</b></h5>
                            <div class="row mb-md-4">
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/frame.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_fname" placeholder="First name" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/frame.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_lname" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/sms.png" class="img-fluid" alt="">
                                        <input type="email" class="form-control" name="co_email" placeholder="Email *" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/call-calling.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_phone" placeholder="Phone *" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/company.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_org" placeholder="Organization/Company">
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/location.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_address1" placeholder="Address line 1" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/location.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_address2" placeholder="Address line 2">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/global.png" class="img-fluid" alt="">
                                        <select class="form-control" name="co_country" required>
                                            <option value=''>Country</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Åland Islands">Åland Islands</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antarctica">Antarctica</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bermuda">Bermuda</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Bouvet Island">Bouvet Island</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <option value="Cayman Islands">Cayman Islands</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Christmas Island">Christmas Island</option>
                                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                            <option value="Cook Islands">Cook Islands</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                            <option value="Faroe Islands">Faroe Islands</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="French Guiana">French Guiana</option>
                                            <option value="French Polynesia">French Polynesia</option>
                                            <option value="French Southern Territories">French Southern Territories</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Gibraltar">Gibraltar</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Greenland">Greenland</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guadeloupe">Guadeloupe</option>
                                            <option value="Guam">Guam</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guernsey">Guernsey</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-bissau">Guinea-bissau</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hong Kong">Hong Kong</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Isle of Man">Isle of Man</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jersey">Jersey</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                            <option value="Korea, Republic of">Korea, Republic of</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Macao">Macao</option>
                                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Martinique">Martinique</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mayotte">Mayotte</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montenegro">Montenegro</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                                            <option value="New Caledonia">New Caledonia</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Niue">Niue</option>
                                            <option value="Norfolk Island">Norfolk Island</option>
                                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Pitcairn">Pitcairn</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Reunion">Reunion</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russian Federation">Russian Federation</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="Saint Helena">Saint Helena</option>
                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                            <option value="Saint Lucia">Saint Lucia</option>
                                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Timor-leste">Timor-leste</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tokelau">Tokelau</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Viet Nam">Viet Nam</option>
                                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                                            <option value="Western Sahara">Western Sahara</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                        <!--<input type="text" class="form-control" name="co_country" placeholder="Country">-->
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/map.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_city" placeholder="City" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/flag-2.png" class="img-fluid" alt="">
                                        <input type="text" class="form-control" name="co_state" placeholder="Province/State" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-3 mb-md-4">
                                    <div class="position-relative">
                                        <img src="includes/images/password-check.png" class="img-fluid" alt="">
                                        <!-- <div id="co_zip"></div> -->
                                        <input type="text" class="form-control" name="co_zip" placeholder="Postal Code / Zip" required>
                                    </div>
                                    <!-- <div id="co_zip_response"></div> -->
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="1" name="app_fee" id="app_fee">
                                <label class="form-check-label" for="app_fee">
                                    <p>I'll cover the processing fee - add it to my donation</p>
                                </label>
                            </div>
                           <hr>
                            <div class="form-check ps-0">
                                <?php
                                foreach ($_SESSION['i_type'] as $key => $value) {
                                    $v = str_replace('_', ' ', $value);
                                            // echo "<pre>"; print_r($_SESSION); die("</pre>");
    
                                    if (!empty($_SESSION['cause'][$v])) {
                                        ?>
                                        <label class="form-check-label my-3 d-flex align-items-center justify-content-between">
                                            <b><?php echo $value ?></b>
                                            <b>
                                                $<?php echo $_SESSION['cause'][$v]?>
                                            </b>
                                        </label>
                                        <?php
                                    } else { ?>
                                        <label class="form-check-label my-3 d-flex align-items-center justify-content-between">
                                            <b><?php echo $value ?></b>
                                            <b>
                                                $<?php echo $_SESSION['cause'][$v]?>
                                            </b>
                                        </label>
                                    <?php }
                                }                                    
                                ?>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p>Subtotal</p>
    
                                    <b>Total</b>
                                </div>
                                <div>
                                    <p>$<span class="total_val"><?php echo $_SESSION['payment'] ?></span></p>
    
                                    <b>$<span class="total_val"><?php echo $_SESSION['payment'] ?></span></b>
                                </div>
                                <input type="hidden" name="selected_payment" value="<?php echo $_SESSION['payment'] ?>">
                                <input type="hidden" name="total_payment" value="<?php echo $_SESSION['payment'] ?>">
                            </div>
                            <div id="paymentError">
                            </div>
                            <div class="text-center my-4">
                                <button type="submit" class="btn py-2 submit_Form" id="donate-btn">Donate </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-4">
                    <div class="checkout_info_right p-4">
                        <?php
                        if (isset($_SESSION['i_type'])) {
                            foreach ($_SESSION['i_type'] as $key => $value) { 
                                ?>
                                <b>Program: <?php echo $key + 1 ?></b>
                                <p><?php echo $value ?></p>
                                <b>Frequency:</b>
                                <p class="mb-0"><?php echo $frequency; ?></p>
                                <?php if (count($_SESSION['i_type']) > $key + 1): ?>
                                    <hr>
                                <?php endif ?>
                                <?php
                            }   
                        }
                        ?>
                        <!-- <b>Program:</b>
                        <p>
                            <?php echo $_SESSION['cause'] ?>
                        </p>
                        <b>
                            Cause:
                        </b>
                        <p>
                            Where Most Needed
                        </p>
                        <b>
                            Frequency:
                        </b>
                        <p>
                            <?php echo $frequency ?>
                        </p>
                        <b>
                            Donation Breakdown:
                        </b>
                        <p>
                            $<?php echo $_SESSION['payment'] ?>
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
        <footer class="py-5 py-md-4">
            <div class="container">
                <div class="d-md-flex justify-content-between align-items-center">
                    <a href="https://handsforcharity.org/">
                        <img src="includes/images/Logo.png" class="img-fluid" alt="logo">
                    </a>
                   <ul class="list-unstyled mt-3 mt-md-0 mb-0 footer_social_icons d-flex align-items-center">
                        <li>
                            <a href="https://www.linkedin.com/company/hands4charity/" class="d-flex align-items-center justify-content-center">
                               <svg fill="#1f92c8" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="100px" height="100px">    <path d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M10.496,8.403 c0.842,0,1.403,0.561,1.403,1.309c0,0.748-0.561,1.309-1.496,1.309C9.561,11.022,9,10.46,9,9.712C9,8.964,9.561,8.403,10.496,8.403z M12,20H9v-8h3V20z M22,20h-2.824v-4.372c0-1.209-0.753-1.488-1.035-1.488s-1.224,0.186-1.224,1.488c0,0.186,0,4.372,0,4.372H14v-8 h2.918v1.116C17.294,12.465,18.047,12,19.459,12C20.871,12,22,13.116,22,15.628V20z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/hands4charity" class="d-flex align-items-center justify-content-center">
                                <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.4 23V14.4H1V9.5H3.4V7.1C3.4 3.7 6.1 1 9.5 1H13.2V5.9H10.8C9.4 5.9 8.4 7 8.4 8.3V9.5H13.3L12 14.4H8.3V23H3.4Z" fill="#0092C8" stroke="#0092C8" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/channel/UCqXuNEB0D9mYdGrhgb_gE2Q" class="d-flex align-items-center justify-content-center">
                                <svg  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                      width="27px" height="20px" viewBox="0 0 27 20" enable-background="new 0 0 27 20" xml:space="preserve">
                                <path fill="#0092C8" d="M12.209,0h1.996h0.822C25.122,0.118,26.883,1.657,27,9.112v0.828v0.947C26.883,18.698,25.004,20,13.735,20
                                      h-1.644h-1.174C1.643,19.882,0.117,18.225,0,10.533V9.586V8.994C0.235,1.42,2.113,0.118,12.209,0z M11.27,6.509v7.101l5.869-3.55
                                      L11.27,6.509z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/hands4charity/" class="d-flex align-items-center justify-content-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 0.5C21.5 0.5 23.5 2.5 23.5 5V19C23.5 21.5 21.5 23.5 19 23.5H5C2.5 23.5 0.5 21.5 0.5 19V5C0.5 2.5 2.5 0.5 5 0.5H19ZM12 5.8C8.5 5.8 5.8 8.6 5.8 12C5.8 15.5 8.6 18.2 12 18.2C15.5 18.2 18.2 15.4 18.2 12C18.2 8.5 15.5 5.8 12 5.8ZM12 7.2C14.6 7.2 16.8 9.3 16.8 12C16.8 14.6 14.7 16.8 12 16.8C9.4 16.8 7.2 14.7 7.2 12C7.2 9.4 9.4 7.2 12 7.2ZM19 3.5C18.2 3.5 17.5 4.2 17.5 5C17.5 5.8 18.2 6.5 19 6.5C19.8 6.5 20.5 5.8 20.5 5C20.5 4.2 19.8 3.5 19 3.5Z" fill="#0092C8"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('pk_test_51KrzE2BwNF8aAhcXNMoFjTtRn2nyHynf61jKNUDmzmSQYNXQAQGPLFol3iNsKmB5VTnrZL1wvxQoXzhAqO5ygqGs00wJghjunP', {
                apiVersion: "2020-08-27",
            });
            
            <?php
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
            $gpay_amout = $_SESSION['payment'] * 100;
            $gpay_amout =  (int)$gpay_amout;
            ?>

            var paymentRequest = stripe.paymentRequest({
                country: 'CA',
                currency: 'cad',
                total: {
                    label: '<?php echo $cause ?>',
                    amount: <?php echo  $gpay_amout?>,
                },
                requestPayerName: true,
                requestPayerEmail: true,
            });
            var elements = stripe.elements();
            var prButton = elements.create('paymentRequestButton', {
                paymentRequest: paymentRequest,
                style: {
                    paymentRequestButton: {
                        type: 'donate',
                        theme: 'dark',
                        height: '40px'
                    },
                },
            });

            paymentRequest.canMakePayment().then(function (result) {
                console.log(result);
                if (result) {
                    prButton.mount('#payment-request-button');
                } else {
                    document.getElementById('payment-request-button').style.display = 'none';
                }
            });

            paymentRequest.on('paymentmethod', function (ev) {
                stripe.confirmCardPayment(
                    clientSecret,
                    {payment_method: ev.paymentMethod.id},
                    {handleActions: false}
                    ).then(function (confirmResult) {
                        if (confirmResult.error) {
                            ev.complete('fail');
                        } else {
                            ev.complete('success');
                            if (confirmResult.paymentIntent.status === "requires_action") {
                                stripe.confirmCardPayment(clientSecret).then(function (result) {
                                    if (result.error) {
                                    } else {
                                    }
                                });
                            } else {
                            }
                        }
                    });
                });
        </script>
        <!--<script src="includes/js/googlepay.js"></script>-->
        <script src="includes/js/custom.js"></script>
        <script src="includes/js/fix.js"></script>
        <script>
            $('.payment_tabs input[name="p_type"]').on('change', function(event) {
                event.preventDefault();
                if ($(this).val() == 'gp') {
                    $('.checkout_form_details').css({
                        'display': 'none',
                    });
                } else {
                    $('.checkout_form_details').css({
                        'display': 'block',
                    });
                }
            });
        </script>
    </body>
</html>