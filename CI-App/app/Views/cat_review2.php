<!doctype html>
<html>
	<head>
		<title>Welcome to FIP warrior data collection</title>
		<meta charset="ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/material-kit.min.css' ?>" />
		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/jquery-ui.css' ?>" />


		<script src="https://kit.fontawesome.com/ed9134ad17.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/fileinput.min.css' ?>" />

		<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

		
		<style {csp-style-nonce}>
			div.logo {
				width: 100%;
				display: inline-block;
				opacity: 0.12;
				z-index: 0;
				top: 2rem;
			}

			.logo img
			{
				width:100%;
			}
			.hidden{
				display:none;
			}
			body {
				height: 100%;
				background: #fafafa;
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				color: #777;
				font-weight: 300;
			}
			h1 {
				font-weight: lighter;
				letter-spacing: 0.8rem;
				font-size: 3rem;
				margin-top: 145px;
				margin-bottom: 0;
				color: #222;
				position: relative;
				z-index: 1;
			}

			p {
				margin-top: 1.5rem;
			}
			.footer {
				margin-top: 2rem;
				border-top: 1px solid #efefef;
				padding: 1em 2em 0 2em;
				font-size: 85%;
				color: #999;
			}
			a:active,
			a:link,
			a:visited {
				color: #dd4814;
			}
			.wrapper
			{
				width:100%;
				padding:24px;
			}

			.error
			{
				color:red;
				font-weight:bold;
			}
			.form{
				margin:12px;
			}

			#xray-form-load
			{
				display:none;
			}
			#echo-form-load
			{
				display:none;
			}
			.fip-type
			{
				padding:12px;
				min-width:96px;
			}
		</style>

	</head>
	<body>

		<script>
			function upload_xray()
			{
				$('#xray-form-load').css('display','inline'); 
				$('#xray-form-submit').prop('disabled','disabled'); 
				$('#xray-form').submit();
			}
			function upload_echo()
			{
				$('#echo-form-load').css('display','inline'); 
				$('#echo-form-submit').prop('disabled','disabled'); 
				$('#echo-form').submit();
			}
		</script>

		<div class="wrapper">
				<div class="container">
				<div class="logo">
					<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
				</div>
				</div>

				<div class="container">
					<div class="jumbotron text-left"><a href="<?= site_url('cat/index/'.$catHash) ?>" >home</a> / upload xray and echographies</div>
				</div>

			<div class="container">

				<h2>below is your cat information</h2>

				<div class="row"><div class="col">first name</div><div class="col"><?= $inputs['parent-first-name'] ?></div></div>
				<div class="row"><div class="col">last name</div><div class="col"><?= $inputs['parent-last-name'] ?></div></div>
				<div class="row"><div class="col">Facebook name</div><div class="col"><?= $inputs['fb-name'] ?></div></div>
				<div class="row"><div class="col">Cat name</div><div class="col"><?= $inputs['cat-name'] ?></div></div>
				<div class="row"><div class="col">Cat's birth date</div><div class="col"><?= $inputs['cat-birthdate'] ?> <?php if($inputs['cat-birthdate-exact'] == 'approx'){ echo " (approximate) "; } ?></div></div>
				<div class="row"><div class="col">Cat gender</div><div class="col"><?= $inputs['cat-gender'] ?> </div></div>
				<div class="row"><div class="col">Cat Fixed</div><div class="col"><?= $inputs['cat-fixed'] ?> </div></div>
				<div class="row"><div class="col">Cat Breed</div><div class="col"><?= $inputs['cat-breed'] ?> </div></div>
				<div class="row"><div class="col">diagnosis</div><div class="col"><?= $inputs['cat-diagnosis'] ?> </div></div>
				<div class="row"><div class="col">diagnosis date</div><div class="col"><?= $inputs['cat-diagnosis-date'] ?> </div></div>
			</div>

			<div class="container text-center">
				<h2>symptoms</h2>
				<div class="row">
					<?php if(count($symptoms['symptoms-wet'])>0) { ?>
						<div class="col"><div class="badge badge-pill badge-warning fip-type"><h4>wet</h4></div></div>
					<?php } ?>
					<?php if(count($symptoms['symptoms-ocular'])>0) { ?>
						<div class="col"><div class="badge badge-pill badge-warning fip-type"><h4>ocular</h4></div></div>
					<?php } ?>
					<?php if(count($symptoms['symptoms-neuro'])>0) { ?>
						<div class="col"><div class="badge badge-pill badge-warning fip-type"><h4>neuro</h4></div></div>
					<?php } ?>
				</div>
			</div>

		<hr/>


		<div class="container text-center">
			<h2>Pictures of your cat</h2>
			<div class="row">
				<?php foreach($pictures as $picture) { ?>
						<div class="col"><img width="256" src="<?= $picture['url'] ?>" alt="cat picture"></div>
				<?php } ?>
			</div>

			<?php if(array_search('ocular',$symptoms['symptoms-FIP'] )) { ?>
				<h2>Picture of your cat's eyes for ocular FIP</h2>
				<div class="row">
					<?php foreach($eyes as $picture) { ?>
							<div class="col"><img width="256" src="<?= $picture['url'] ?>" alt="cat eyes">
							<div class="date">date : <?= $picture['date'] ?></div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

		</div>

		<?php if($error) { echo '<div class="container"><span class="error text-center">'.$error.'</span></div>'; } ?>

		<div class="container">
			<h2>Upload xray pictures if you have them</h2>

			<div class="row">
				<?php foreach($xrays as $picture) { ?>
					<div class="col text-center">
						<img width="256" src="<?= $picture['url'] ?>" alt="cat xray">
						<div class="date">date : <?= $picture['date'] ?> </div>
						<form action="<?= site_url('Cat/del_tmp_xray/'.$catHash.'/'.$picture['file']) ?>" method="POST">
							<input type="submit" value="del" class="btn btn-primary" />
						</form>
					</div>


				<?php } ?>
			</div>

			<form action="<?= site_url('Cat/add_tmp_xray/'.$catHash) ?> " id="xray-form" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header text-center"><h3>Upload Xray if you have them</h3><br/><img id="xray-form-load" width="64" src="<?= base_url().'assets/img/loading.gif' ?>" alt="loading" /></div>
					<div class="card-bod text-center">
						<div class="form-group ">
							<p>Date: <input type="text" name="xray-date" id="xray-date" value="<?= $xrayDate ?>"></p>
						</div>


						<div class="btn btn-primary btn-file">
							<span class="hidden-xs">Select xray picture</span>
							<input  name="cat-xray" id="cat-xray" type="file" data-allowed-file-extensions='["jpg", "jpeg"]'>
						</div>

					</div>
					
				 </div>
			</form>
		</div>

		<div class="container">
			<h2>Upload echography pictures if you have them</h2>
			<div class="row">
				<?php foreach($echographies as $picture) { ?>
					<div class="col text-center">
						<img width="256" src="<?= $picture['url'] ?>" alt="cat echography" />
						<div class="date">date : <?= $picture['date'] ?></div>
						<form action="<?= site_url('Cat/del_tmp_echo/'.$catHash.'/'.$picture['file']) ?>" method="POST">
							<input type="submit" value="del" class="btn btn-primary" />
						</form>
					</div>
				<?php } ?>
			</div>
			<form action="<?= site_url('Cat/add_tmp_echography/'. $catHash) ?> " id="echo-form" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header text-center"><h3>Upload echography picture if you have them</h3><br/><img id="echo-form-load" width="64" src="<?= base_url().'assets/img/loading.gif' ?>" alt="loading" /></div>
					<div class="card-body text-center">
						<div class="form-group ">
							<p>Date: <input type="text" name="echography-date" id="echography-date" value="<?= $echoDate ?>"></p>
						</div>

						<div class="btn btn-primary btn-file">
							<span class="hidden-xs">Select echography picture</span>
							<input name="cat-echography" id="cat-echography" type="file" data-allowed-file-extensions='["jpg", "jpeg"]'>
						</div>
					</div>
					
				 </div>
			</form>
		</div>


		<div class="container">
			<div class="row">
				<div class="col text-left"> <a class="btn btn-primary" href="<?= site_url('Cat/review_step2/'.$catHash) ?>">back</a></div>
				<div class="col text-right"><a class="btn btn-primary" href="<?= site_url('Cat/review_step4/'.$catHash) ?>">next</a></div>
			</div>
		</div>


		<div class="footer">
			Page rendered in {elapsed_time} seconds. Environment: <?= ENVIRONMENT ?>
		</div>

		</div>

		<script src="<?= base_url().'assets/js/core/jquery.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/core/popper.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/core/bootstrap-material-design.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/material-kit.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/core/jquery-ui.js' ?>"></script>
		<script src="<?= base_url().'assets/js/plugins/fileinput.min.js' ?>"></script>
		<script src="<?= base_url().'assets/js/plugins/theme.min.js' ?>"></script>

		<script>
				$(document).ready(function() {
						$( "#xray-date" ).datepicker(); 
						$( "#xray-date" ).datepicker("setDate", "<?= $xrayDate ?>"); 
						$( "#echography-date" ).datepicker(); 
						$( "#echography-date" ).datepicker("setDate", "<?= $echoDate ?>");

						$("#cat-xray").fileinput({ theme: "fa",showCaption: false, dropZoneEnabled: false,showRemove: false});
						$("#cat-echography").fileinput({ theme: "fa",showCaption: false, dropZoneEnabled: false,showRemove: false});
				});
		</script>

		
	</body>
</html>
