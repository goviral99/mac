<?php 
	include_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="includes/images/smalllogo.png">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>
<body>


	<div class="mainFormWrap mh-100 d-md-flex align-items-center position-relative">
		<div class="container w-100">
			<div class="row">
			<div class="col-md-6 py-4">
				<?php if (!empty($_SESSION['statusMsg'])): ?>
					<div class="mb-0">
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<svg x="0px" y="0px" width="24px" height="24px" viewBox="-3.994 -4 24 24" enable-background="new -3.994 -4 24 24" xml:space="preserve">
								<path fill="#664D03" d="M8,19.942c6.595,0,11.942-5.347,11.942-11.942S14.595-3.942,8-3.942S-3.942,1.405-3.942,8
								S1.405,19.942,8,19.942z M9.388,5.892l-1.493,7.023c-0.104,0.508,0.043,0.796,0.454,0.796c0.29,0,0.727-0.104,1.024-0.367
								l-0.131,0.621c-0.428,0.516-1.373,0.893-2.187,0.893c-1.049,0-1.496-0.63-1.206-1.969l1.102-5.177
								C7.046,7.275,6.96,7.116,6.522,7.01L5.849,6.889l0.122-0.569L9.39,5.892L9.388,5.892z M8,4.268c-0.824,0-1.493-0.668-1.493-1.493
								S7.176,1.283,8,1.283s1.493,0.668,1.493,1.493S8.824,4.268,8,4.268z"/>
							</svg>
							<?php 
							echo $_SESSION['statusMsg']; 
							session_destroy();
							session_start();
							?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					</div>
				<?php endif ?>
				<form action="checkout.php" method="post">
					<a href="https://handsforcharity.org">
						<img src="includes/images/Logo.png" class="img-fluid" alt="Logo">
					</a>
					<h1 class="mainTitle mt-3 mb-2">Select A Category</h1>
					<ul class="list-unstyled row mb-0 i_type_list main_list">
						<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type1" type="checkbox" name="i_type[]" value="Orphan Sponsorship" data-amount-one="1 Orphan,2 Orphans,3 Orphans" data-amount-monthly="1 Orphan,2 Orphans,3 Orphans" data-amount-yearly="1 Orphan,2 Orphans,3 Orphans">
								<label for="i_type1" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img1.jpg" data-text="Whoever takes care of an orphan, he and I will be together in Paradise like this (his index and middle fingers held close together) – Prophet Muhammad (PBUH)

">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon1.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Orphan Sponsorship
								</label>
							</div>
						</li>
						<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type2" type="checkbox" name="i_type[]" value="Refugees Reliefs" data-amount-one="1000,500,200" data-amount-monthly="500,200,100" data-amount-yearly="1000,500,200">
								<label for="i_type2" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img2.jpg" data-text="Our programs are directed to provide refugees with basic necessities like shelter, food, water, and hygiene kits, in addition to long-term support in education and healthcare.">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon2.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Refugees Reliefs
								</label>
							</div>
						</li>
						<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type3" type="checkbox" name="i_type[]" value="Water Wells" data-amount-one="5000,2500,500" data-amount-monthly="1000,500,200" data-amount-yearly="5000,250,500">
								<label for="i_type3" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img3.jpg" data-text="Prophet Muhammad (SAW) said: “The best charity is giving water to drink” [Ahmad] and he was the most generous in giving charity

.">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon3.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Water Wells
								</label>
							</div>
						</li>
						<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type4" type="checkbox" name="i_type[]" value="Zakat" data-amount-one="100,50,10" data-amount-monthly="100,50,10" data-amount-yearly="100,50,10">
								<label for="i_type4" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img7.jpg" data-text="“…and those in whose wealth there is a recognised right, for the needy and deprived” (Al-Ma’arij 70:24-25)

">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon4.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Zakat
								</label>
							</div>
						</li>
							<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type5" type="checkbox" name="i_type[]" value="Pakistan Flood" data-amount-one="1000,500,200" data-amount-monthly="500,200,100" data-amount-yearly="1000,500,200">
								<label for="i_type5" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img10.jpg" data-text="Millions of families have been affected by the devasting floods in Pakistan. The death toll from floods has crossed 1,000 in Pakistan and thousands more have been injured or displaced since June. 
								
			

">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon2.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Pakistan Flood
								</label>
							</div>
						</li>
							<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type6" type="checkbox" name="i_type[]" value="Palestine Support" data-amount-one="1000,500,200" data-amount-monthly="1000,500,200" data-amount-yearly="1000,500,200">
								<label for="i_type6" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/img15.jpg" data-text="People of Palestine are faced with a new tragedy that increases their suffering. Thousands of people are in urgent need of treatment, and Hundreds of families are left without shelter, food, or medicine after their houses were destroyed. [Photo by: Mohammed Salem]

">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon2.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Palestine Support
								</label>
							</div>
						</li>
						
						<li class="col-6">
							<div class="i_input_inner">
								<input id="i_type7" type="checkbox" name="i_type[]" value="Winter Campaign" data-amount-one="150,80,60" data-amount-monthly="150,80,60" data-amount-yearly="150,80,60">
								<label for="i_type7" class="d-flex p-2 py-lg-3 align-items-center" data-img-url="includes/images/winter.jpg" data-text="The suffering of the refugee camps in Lebanon continues during the cold winter which leaves the refugees in a tragic situation, and many children, patients, and elderly die every year.

">
									<!-- <div class="i_type_icon me-3">
										<img src="includes/images/icon2.svg" class="img-fluid" alt="">
									</div> -->
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Winter Campaign
								</label>
							</div>
						</li>
						
					</ul>
					<p class="mt-2 mb-3">
Please select a category you would like to donate too. You may select more then one category within a single transaction.				</p>
					<h5 class="mb-0"><b>Giving Plan</b></h5>
					<ul class="list-unstyled g_opts_list row mb-2">
						<li class="col-sm-6 py-2 col-6">
							<div class="i_input_inner opts_rand">
								<input id="g_opts1" type="radio" name="g_opts" value="0" checked>
								<label for="g_opts1" for="" class="p-2 py-lg-3 w-100">
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									One-time 
								</label>
							</div>
						</li>
						<li class="col-sm-6 py-2 col-6">
							<div class="i_input_inner opts_rand">
								<input id="g_opts2" type="radio" name="g_opts" value="1">
								<label for="g_opts2" for="" class="p-2 py-lg-3 w-100">
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Monthly 
								</label>
							</div>
						</li>
						<li class="col-sm-6 py-2 col-6">
							<div class="i_input_inner opts_rand">
								<input id="g_opts3" type="radio" name="g_opts" value="2">
								<label for="g_opts3" for="" class="p-2 py-lg-3 w-100">
									<svg class="me-3" width="20" height="20" viewBox="0 0 20 20" fill="none">
										<path d="M10 0C4.49 0 0 4.49 0 10C0 15.51 4.49 20 10 20C15.51 20 20 15.51 20 10C20 4.49 15.51 0 10 0ZM14.78 7.7L9.11 13.37C8.97 13.51 8.78 13.59 8.58 13.59C8.38 13.59 8.19 13.51 8.05 13.37L5.22 10.54C4.93 10.25 4.93 9.77 5.22 9.48C5.51 9.19 5.99 9.19 6.28 9.48L8.58 11.78L13.72 6.64C14.01 6.35 14.49 6.35 14.78 6.64C15.07 6.93 15.07 7.4 14.78 7.7Z" fill="#71758E"/>
									</svg>
									Yearly 
								</label>
							</div>
						</li>
					</ul>
				
					<div class="selected_amount_wrapper list-unstyled mb-0">
					 	
					</div>
					
					<button type="submit" class="btn py-2">Donate Now</button>
				</form>
			</div>
			</div>
		</div>
		<div class="mainFormImg" style="background: url('includes/images/img1.jpg');">
			<div class="mainImg_txt_wrap">
				<div class="mainImg_txt">
Whoever takes care of an orphan, he and I will be together in Paradise like this (his index and middle fingers held close together) – Prophet Muhammad (PBUH)

			</div>
		</div>
	</div>


	<?php if (!isset($_SESSION['user_id'])){
		session_destroy();
	} ?>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="includes/js/custom.js"></script>
	<script>
		function _0x5d5c(){var _0x552599=['<input\x20id=\x27','[]\x27\x20value=\x27\x27>','toLowerCase','<div\x20class=\x27g_opts_inner\x27>',':checked','removeAttr','818qGpHFn','split','.g_opts_inner_other\x20label\x20input','append','data-amount-monthly','<div\x20class=\x27g_opts_inner\x20g_opts_inner_other\x27>','4\x27\x20type=\x27radio\x27\x20name=\x27','none','val','<li\x20class=\x27col-12\x27><b\x20class=\x27other_val_amount\x27></b></li>','input','<li\x20class=\x27col\x20py-2\x27>','checked','.main_list\x20input','</b></li>','closest','.selected_amount_wrapper','4\x27\x20class=\x27p-2\x20py-lg-3\x20d-flex\x20align-items-center\x27><span>4+</span><input\x20type=\x27number\x27\x20min=\x270\x27\x20class=\x27form-control\x27\x20name=\x27','find','8GUOOmP','change','1\x27\x20type=\x27radio\x27\x20name=\x27','2\x27\x20type=\x27radio\x27\x20name=\x27','4\x27\x20class=\x27p-2\x20py-lg-3\x20d-flex\x20align-items-center\x27><span>$</span><input\x20type=\x27number\x27\x20min=\x270\x27\x20class=\x27form-control\x27\x20name=\x27','2528772cudTgC','css','\x20.g_opts_inner:not(.g_opts_inner_other)','disabled','7541947tMXYkn','4MsrFDt','replace','html','</div>','4\x27\x20class=\x27p-2\x20py-lg-3\x27></label>','[]\x27></label>','Maximum\x20for\x20monthly\x20is\x20100','14862321RliSud','preventDefault','16090200lERoiO','Orphan','label','text','</li>','click','data-amount-one','726180ERShJg','includes','.g_opts_inner:not(.g_opts_inner_other)>input','2\x27\x20class=\x27p-2\x20py-lg-3\x27></label>','Orphans','<li\x20class=\x27col-12\x27><hr\x20class=\x27my-1\x27></li>','.main_list\x20input:checked','4899775RPDUzX','.g_opts_list\x20input:checked','3\x27\x20type=\x27radio\x27\x20name=\x27','.i_type_list.main_list:not(.g_opts_list)\x20input','3449gUmkuy','.cause_type_amount_list\x20button','indexOf','attr','.g_opts_list\x20input','.other_val_amount','each','children','prop','<label\x20for=\x27','<li\x20class=\x27col-12\x20pt-2\x27><b\x20class=\x27d-flex\x20align-items-center\x27><button\x20type=\x27button\x27><svg\x20class=\x27me-1\x27\x20width=\x2720\x27\x20height=\x2720\x27\x20viewBox=\x270\x200\x2020\x2020\x27\x20fill=\x27none\x27><path\x20d=\x27M10\x200C4.49\x200\x200\x204.49\x200\x2010C0\x2015.51\x204.49\x2020\x2010\x2020C15.51\x2020\x2020\x2015.51\x2020\x2010C20\x204.49\x2015.51\x200\x2010\x200ZM13.36\x2012.3C13.65\x2012.59\x2013.65\x2013.07\x2013.36\x2013.36C13.21\x2013.51\x2013.02\x2013.58\x2012.83\x2013.58C12.64\x2013.58\x2012.45\x2013.51\x2012.3\x2013.36L10\x2011.06L7.7\x2013.36C7.55\x2013.51\x207.36\x2013.58\x207.17\x2013.58C6.98\x2013.58\x206.79\x2013.51\x206.64\x2013.36C6.35\x2013.07\x206.35\x2012.59\x206.64\x2012.3L8.94\x2010L6.64\x207.7C6.35\x207.41\x206.35\x206.93\x206.64\x206.64C6.93\x206.35\x207.41\x206.35\x207.7\x206.64L10\x208.94L12.3\x206.64C12.59\x206.35\x2013.07\x206.35\x2013.36\x206.64C13.65\x206.93\x2013.65\x207.41\x2013.36\x207.7L11.06\x2010L13.36\x2012.3Z\x27\x20fill=\x27#292D32\x27/></svg></button>','data-amount-yearly','.g_opts_list\x20input[value=0]','length'];_0x5d5c=function(){return _0x552599;};return _0x5d5c();}var _0x431201=_0x4ee4;function _0x4ee4(_0x56c782,_0x1f03ef){var _0x5d5cc8=_0x5d5c();return _0x4ee4=function(_0x4ee4f4,_0x5d4b95){_0x4ee4f4=_0x4ee4f4-0xae;var _0x59aecf=_0x5d5cc8[_0x4ee4f4];return _0x59aecf;},_0x4ee4(_0x56c782,_0x1f03ef);}(function(_0x9581b3,_0x455fc2){var _0x1b0d0c=_0x4ee4,_0x3dc46b=_0x9581b3();while(!![]){try{var _0x1a7922=-parseInt(_0x1b0d0c(0xc9))/0x1*(parseInt(_0x1b0d0c(0xdd))/0x2)+parseInt(_0x1b0d0c(0xf5))/0x3*(-parseInt(_0x1b0d0c(0xae))/0x4)+-parseInt(_0x1b0d0c(0xc5))/0x5+-parseInt(_0x1b0d0c(0xbe))/0x6+-parseInt(_0x1b0d0c(0xf9))/0x7*(-parseInt(_0x1b0d0c(0xf0))/0x8)+parseInt(_0x1b0d0c(0xb5))/0x9+parseInt(_0x1b0d0c(0xb7))/0xa;if(_0x1a7922===_0x455fc2)break;else _0x3dc46b['push'](_0x3dc46b['shift']());}catch(_0x3f7903){_0x3dc46b['push'](_0x3dc46b['shift']());}}}(_0x5d5c,0xf00dc),$(_0x431201(0xea))['on'](_0x431201(0xf1),function(_0x1cd7da){var _0x395da2=_0x431201;_0x1cd7da[_0x395da2(0xb6)](),$('.main_list\x20input:checked')[_0x395da2(0xd6)]>0x1?($(_0x395da2(0xcd))[_0x395da2(0xcc)](_0x395da2(0xf8),'disabled'),$(_0x395da2(0xd5))[_0x395da2(0xd1)](_0x395da2(0xe9),!![]),$(_0x395da2(0xd5))[_0x395da2(0xdc)](_0x395da2(0xf8)),$(_0x395da2(0xc4))['each'](function(_0x3a96c2,_0x2a35d6){var _0xeb1873=_0x395da2,_0xdf2774=$(this)[_0xeb1873(0xe5)](),_0x5a6c4d=$(this)[_0xeb1873(0xe5)]()[_0xeb1873(0xd9)]()['replace']('\x20','_'),_0x1858a2=$(_0xeb1873(0xc6))[_0xeb1873(0xe5)]();if(_0x1858a2==0x0)var _0x252556=$(this)['attr'](_0xeb1873(0xbd));if(_0x1858a2==0x1)var _0x252556=$(this)[_0xeb1873(0xcc)](_0xeb1873(0xe1));if(_0x1858a2==0x2)var _0x252556=$(this)[_0xeb1873(0xcc)](_0xeb1873(0xd4));_0x252556=_0x252556['split'](','),$($('#'+_0x5a6c4d+_0xeb1873(0xf7)))[_0xeb1873(0xcf)](function(_0x327f5d,_0x11837c){var _0x132712=_0xeb1873;$(this)[_0x132712(0xd0)](_0x132712(0xe7))[_0x132712(0xe5)](_0x252556[_0x327f5d]),$(this)['children'](_0x132712(0xb9))[_0x132712(0xba)](_0x252556[_0x327f5d]);});})):($(_0x395da2(0xcd))['removeAttr'](_0x395da2(0xf8)),$(_0x395da2(0xc4))[_0x395da2(0xcf)](function(_0x44a9df,_0x50043d){var _0x4738cc=_0x395da2;$(this)[_0x4738cc(0xcc)]('data-amount-yearly')==''&&$('.g_opts_list\x20input[value=\x222\x22]')[_0x4738cc(0xcc)]('disabled',_0x4738cc(0xf8));})),$(this)[_0x395da2(0xd1)](_0x395da2(0xe9))==!![]&&($(this)[_0x395da2(0xcc)](_0x395da2(0xd4))==''&&$('.g_opts_list\x20input[value=\x222\x22]')[_0x395da2(0xcc)](_0x395da2(0xf8),'disabled'));}),$(_0x431201(0xcd))['on'](_0x431201(0xf1),function(_0x390a00){var _0x4cee82=_0x431201;_0x390a00[_0x4cee82(0xb6)](),$(_0x4cee82(0xc4))[_0x4cee82(0xd6)]>0x1&&$(_0x4cee82(0xd5))[_0x4cee82(0xd1)]('checked',!![]),$('.main_list\x20input:checked')[_0x4cee82(0xd6)]>0x0&&$('.main_list\x20input:checked')['each'](function(_0x17fac2,_0x2c7a1a){var _0x35dc53=_0x4cee82,_0x188466=$(this)[_0x35dc53(0xe5)](),_0x221218=$(this)[_0x35dc53(0xe5)]()[_0x35dc53(0xd9)]()['replace']('\x20','_'),_0x31e6b3=$(_0x35dc53(0xc6))[_0x35dc53(0xe5)]();if(_0x31e6b3==0x0)var _0x42a4e8=$(this)['attr'](_0x35dc53(0xbd));if(_0x31e6b3==0x1)var _0x42a4e8=$(this)[_0x35dc53(0xcc)](_0x35dc53(0xe1));if(_0x31e6b3==0x2)var _0x42a4e8=$(this)['attr'](_0x35dc53(0xd4));_0x42a4e8=_0x42a4e8[_0x35dc53(0xde)](','),$($('#'+_0x221218+'\x20.g_opts_inner:not(.g_opts_inner_other)'))['each'](function(_0x5df213,_0x2d60a6){var _0x26c0e6=_0x35dc53;$(this)[_0x26c0e6(0xd0)]('input')[_0x26c0e6(0xe5)](_0x42a4e8[_0x5df213]),$(this)[_0x26c0e6(0xd0)](_0x26c0e6(0xb9))[_0x26c0e6(0xba)](_0x42a4e8[_0x5df213]);});}),$('.g_opts_inner')[_0x4cee82(0xcf)](function(_0xd1350f,_0x3e5f6e){var _0x56aeb=_0x4cee82;$(this)[_0x56aeb(0xd0)](_0x56aeb(0xe7))['prop'](_0x56aeb(0xe9),![]);}),$(_0x4cee82(0xce))[_0x4cee82(0xcf)](function(_0x45b8cd,_0x408d50){var _0x226095=_0x4cee82;$(this)[_0x226095(0xb0)]('');});}),$(_0x431201(0xc8))[_0x431201(0xcf)](function(_0x39b9b5,_0x456d94){var _0x53ae1b=_0x431201,_0x1f454c='',_0x40665f=$(this)[_0x53ae1b(0xe5)](),_0x2f3429=$(this)['val']()[_0x53ae1b(0xd9)]()[_0x53ae1b(0xaf)]('\x20','_'),_0x223633=$(this)['attr']('data-amount-one');_0x223633=_0x223633['split'](','),_0x1f454c+='<ul\x20class=\x27list-unstyled\x20cause_type_amount_list\x20row\x20mb-0\x20align-items-center\x27\x20id=\x27'+_0x2f3429+'\x27\x20style=\x27display:none\x27>',_0x1f454c+=_0x53ae1b(0xd3)+_0x40665f+_0x53ae1b(0xeb),_0x1f454c+=_0x53ae1b(0xe8),_0x1f454c+=_0x53ae1b(0xda),_0x1f454c+='<input\x20id=\x27'+_0x2f3429+_0x53ae1b(0xf2)+_0x40665f+'[]\x27\x20value=\x27\x27>',_0x1f454c+=_0x53ae1b(0xd2)+_0x2f3429+'1\x27\x20class=\x27p-2\x20py-lg-3\x27></label>',_0x1f454c+=_0x53ae1b(0xb1),_0x1f454c+=_0x53ae1b(0xbb),_0x1f454c+=_0x53ae1b(0xe8),_0x1f454c+=_0x53ae1b(0xda),_0x1f454c+='<input\x20id=\x27'+_0x2f3429+_0x53ae1b(0xf3)+_0x40665f+'[]\x27\x20value=\x27\x27>',_0x1f454c+=_0x53ae1b(0xd2)+_0x2f3429+_0x53ae1b(0xc1),_0x1f454c+='</div>',_0x1f454c+='</li>',_0x1f454c+=_0x53ae1b(0xe8),_0x1f454c+=_0x53ae1b(0xda),_0x1f454c+='<input\x20id=\x27'+_0x2f3429+_0x53ae1b(0xc7)+_0x40665f+_0x53ae1b(0xd8),_0x1f454c+=_0x53ae1b(0xd2)+_0x2f3429+'3\x27\x20class=\x27p-2\x20py-lg-3\x27></label>',_0x1f454c+='</div>',_0x1f454c+='</li>',_0x223633[_0x53ae1b(0xd6)]==0x4?(_0x1f454c+='<li\x20class=\x27col\x20py-2\x27>',_0x1f454c+='<div\x20class=\x27g_opts_inner\x27>',_0x1f454c+=_0x53ae1b(0xd7)+_0x2f3429+'4\x27\x20type=\x27radio\x27\x20name=\x27'+_0x40665f+'[]\x27\x20value=\x27\x27>',_0x1f454c+='<label\x20for=\x27'+_0x2f3429+_0x53ae1b(0xb2),_0x1f454c+=_0x53ae1b(0xb1),_0x1f454c+=_0x53ae1b(0xbb)):(_0x1f454c+=_0x53ae1b(0xe8),_0x1f454c+=_0x53ae1b(0xe2),_0x1f454c+=_0x53ae1b(0xd7)+_0x2f3429+_0x53ae1b(0xe3)+_0x40665f+_0x53ae1b(0xd8),_0x40665f[_0x53ae1b(0xcb)]('Orphan')>=0x0?_0x1f454c+='<label\x20for=\x27'+_0x2f3429+_0x53ae1b(0xee)+_0x40665f+_0x53ae1b(0xb3):_0x1f454c+=_0x53ae1b(0xd2)+_0x2f3429+_0x53ae1b(0xf4)+_0x40665f+'[]\x27></label>',_0x1f454c+='</div>',_0x1f454c+=_0x53ae1b(0xbb)),_0x1f454c+='<li\x20class=\x27col-12\x27></li>',_0x1f454c+=_0x53ae1b(0xe6),_0x1f454c+=_0x53ae1b(0xc3),_0x1f454c+='</ul>',$(_0x53ae1b(0xed))[_0x53ae1b(0xe0)](_0x1f454c);}),$(_0x431201(0xc8))['on'](_0x431201(0xf1),function(_0x49cb3f){var _0x1d3c08=_0x431201;_0x49cb3f['preventDefault']();var _0x176b69=$(this)['val'](),_0x317f5c=$(this)['val']()[_0x1d3c08(0xd9)]()[_0x1d3c08(0xaf)]('\x20','_');if($(this)['is'](_0x1d3c08(0xdb))){var _0x24549f=$('.g_opts_list\x20input:checked')[_0x1d3c08(0xe5)]();if(_0x24549f==0x0)var _0x21692d=$(this)[_0x1d3c08(0xcc)]('data-amount-one');if(_0x24549f==0x1)var _0x21692d=$(this)[_0x1d3c08(0xcc)](_0x1d3c08(0xe1));if(_0x24549f==0x2)var _0x21692d=$(this)[_0x1d3c08(0xcc)]('data-amount-yearly');_0x21692d=_0x21692d[_0x1d3c08(0xde)](','),$($('#'+_0x317f5c+_0x1d3c08(0xf7)))[_0x1d3c08(0xcf)](function(_0xfcebed,_0x3b8ffd){var _0x1ddc1e=_0x1d3c08;$(this)['children'](_0x1ddc1e(0xe7))[_0x1ddc1e(0xe5)](_0x21692d[_0xfcebed]),$(this)[_0x1ddc1e(0xd0)](_0x1ddc1e(0xb9))[_0x1ddc1e(0xba)](_0x21692d[_0xfcebed]);});}$(this)['is'](_0x1d3c08(0xdb))?$('#'+_0x317f5c)['css']({'display':'flex'}):($('#'+_0x317f5c)[_0x1d3c08(0xf6)]({'display':'none'}),$('#'+_0x317f5c)[_0x1d3c08(0xef)](_0x1d3c08(0xe7))[_0x1d3c08(0xd1)](_0x1d3c08(0xe9),![]),$('#'+_0x317f5c)[_0x1d3c08(0xef)](_0x1d3c08(0xce))[_0x1d3c08(0xba)](''));}),$(_0x431201(0xc0))['on'](_0x431201(0xf1),function(_0xcbddf2){var _0xdfbdb1=_0x431201;$(this)['closest']('ul')['find'](_0xdfbdb1(0xdf))[_0xdfbdb1(0xe5)]('');if($(this)['is'](':checked')){let _0x3270bd=$(this)[_0xdfbdb1(0xe5)]();if(_0x3270bd['includes'](_0xdfbdb1(0xb8))||_0x3270bd[_0xdfbdb1(0xbf)](_0xdfbdb1(0xc2))){_0x3270bd=_0x3270bd['replace'](_0xdfbdb1(0xc2),''),_0x3270bd=_0x3270bd[_0xdfbdb1(0xaf)]('Orphan',''),_0x3270bd=_0x3270bd[_0xdfbdb1(0xaf)]('\x20','');var _0x5943d0=$('.g_opts_list\x20input:checked')['val']();if(_0x5943d0==0x0||_0x5943d0==0x2)var _0x322e07=0x348*parseInt(_0x3270bd);if(_0x5943d0==0x1)var _0x322e07=0x46*parseInt(_0x3270bd);$(this)[_0xdfbdb1(0xec)]('ul')[_0xdfbdb1(0xef)](_0xdfbdb1(0xce))['text']('$'+_0x322e07);}else $(this)[_0xdfbdb1(0xec)]('ul')['find'](_0xdfbdb1(0xce))['text']('$'+$(this)[_0xdfbdb1(0xe5)]());}}),$('.g_opts_inner_other\x20label\x20input')['on']('keyup',function(_0x2d2999){var _0x31b503=_0x431201;_0x2d2999['preventDefault']();let _0x231bb1=$(this)['attr']('name');if(_0x231bb1[_0x31b503(0xbf)](_0x31b503(0xb8))||_0x231bb1[_0x31b503(0xbf)](_0x31b503(0xc2))){let _0x1dc3c7=$(this)[_0x31b503(0xe5)]();_0x1dc3c7=_0x1dc3c7[_0x31b503(0xaf)](_0x31b503(0xc2),''),_0x1dc3c7=_0x1dc3c7['replace'](_0x31b503(0xb8),''),_0x1dc3c7=_0x1dc3c7[_0x31b503(0xaf)]('\x20','');var _0x315bd3=$(_0x31b503(0xc6))[_0x31b503(0xe5)]();if(_0x315bd3==0x0||_0x315bd3==0x2){_0x1dc3c7>0x14&&(alert('Maximum\x20limit\x20is\x2020'),$(this)[_0x31b503(0xe5)](0x14),_0x1dc3c7=0x14);var _0x1ab217=0x348*parseInt(_0x1dc3c7);}if(_0x315bd3==0x1){_0x1dc3c7>0x64&&(alert(_0x31b503(0xb4)),$(this)['val'](0x64),_0x1dc3c7=0x64);var _0x1ab217=0x46*parseInt(_0x1dc3c7);}$(this)['closest']('ul')['find'](_0x31b503(0xce))['text']('$'+_0x1ab217);}else $(this)[_0x31b503(0xec)]('ul')[_0x31b503(0xef)](_0x31b503(0xce))[_0x31b503(0xba)]('$'+$(this)[_0x31b503(0xe5)]());}),$(_0x431201(0xca))['on'](_0x431201(0xbc),function(_0x28f01d){var _0x1e003c=_0x431201;_0x28f01d['preventDefault']();var _0x31fe78=$(this)[_0x1e003c(0xec)]('ul')['attr']('id');$(this)['closest']('ul')[_0x1e003c(0xf6)]({'display':_0x1e003c(0xe4)}),$(this)['closest']('ul')[_0x1e003c(0xef)](_0x1e003c(0xe7))[_0x1e003c(0xd1)](_0x1e003c(0xe9),![]),$(this)[_0x1e003c(0xec)]('ul')[_0x1e003c(0xef)](_0x1e003c(0xce))['text'](''),_0x31fe78=_0x31fe78[_0x1e003c(0xaf)]('_','\x20'),$(_0x1e003c(0xea))[_0x1e003c(0xcf)](function(_0x50eff4,_0x56ff0a){var _0x3ae5d5=_0x1e003c;$(this)['val']()[_0x3ae5d5(0xd9)]()==_0x31fe78&&$(this)[_0x3ae5d5(0xd1)](_0x3ae5d5(0xe9),![]);});}));
	</script>
</body>
</html>