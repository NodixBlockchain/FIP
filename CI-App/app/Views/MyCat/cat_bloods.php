﻿<!doctype html>
<html>
	<head>
		<title>Welcome to FIP warrior data collection</title>
		<meta charset="ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/material-kit.min.css' ?>" />
		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/jquery-ui.css' ?>" />

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
			.wrapper
			{
				margin-top: 64px;
			}
			.blood-pic-lnk
			{
				margin:4px;
			}
		</style>

	</head>
	<body>
		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
			<a class="navbar-brand" href="<?= base_url(); ?>">FIP Warrior</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
     
  			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item"><a class="nav-link" href="<?= site_url('MyCat/my_infos') ?>">My infos</a></li>
					<li class="nav-item"><a class="nav-link" href="<?= site_url('MyCat/index') ?>">My cats</a></li>
					<li class="nav-item"><a class="nav-link" href="<?= site_url('MyCat/my_cat/'.$cat['cat-hash']); ?>" >General</a></li>
					<li class="nav-item dropdown active">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Metrics</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
							<a class="dropdown-item" href="<?= site_url('MyCat/my_cat_infos/'.$cat['cat-hash']); ?>" >Cat Metrics</a>
							<a class="dropdown-item" href="<?= site_url('MyCat/my_cat_symptoms/'.$cat['cat-hash']); ?>" >Symptoms</a>
							<a class="dropdown-item active" href="<?= site_url('MyCat/my_cat_blood/'.$cat['cat-hash']); ?>" >Bloods</a>
						 </div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pictures</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?= site_url('MyCat/my_cat_eyes/'.$cat['cat-hash']); ?>" >Eyes</a>				 
							<a class="dropdown-item" href="<?= site_url('MyCat/my_cat_xrays/'.$cat['cat-hash']); ?>" >Xrays</a>				 
							<a class="dropdown-item" href="<?= site_url('MyCat/my_cat_echographies/'.$cat['cat-hash']); ?>" >Echographies</a>
						 </div>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?= site_url('MyCat/signout') ?>">Sign out</a></a></li>
				</ul>
			</div>
		</nav>
		<div class="wrapper">
			<div class="container">
			<div class="logo">
				<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
			</div>
			</div>


			

			<div class="container">

				<h2>below is your cat information</h2>

				<div class="row"><div class="col">first name</div><div class="col"><?= $cat['parent-first-name'] ?></div></div>
				<div class="row"><div class="col">last name</div><div class="col"><?= $cat['parent-last-name'] ?></div></div>
				<div class="row"><div class="col">Facebook name</div><div class="col"><?= $cat['fb-name'] ?></div></div>
				<div class="row"><div class="col">Cat name</div><div class="col"><?= $cat['cat-name'] ?></div></div>
				<div class="row"><div class="col">Cat's birth date</div><div class="col"><?= $cat['cat-birthdate'] ?> <?php if($cat['cat-birthdate-exact'] == 'approx'){ echo " (approximate) "; } ?></div></div>
				<div class="row"><div class="col">Cat gender</div><div class="col"><?= $cat['cat-gender'] ?> </div></div>
				<div class="row"><div class="col">Cat Fixed</div><div class="col"><?= $cat['cat-fixed'] ?> </div></div>
				<div class="row"><div class="col">Cat Breed</div><div class="col"><?= $cat['cat-breed'] ?> </div></div>
				<div class="row"><div class="col">diagnosis</div><div class="col"><?= $cat['cat-diagnosis'] ?> </div></div>
				<div class="row"><div class="col">diagnosis date</div><div class="col"><?= $cat['cat-diagnosis-date'] ?> </div></div>
				<div class="row"><div class="col text-center"><a class="btn btn-primary" href="<?php echo site_url('MyCat/my_cat/'.$cat['cat-hash']); ?>" >More infos</a></div></div>
			</div>

			<hr/>

			<div class="container text-center">
			
				<h2>Blood work for the cat</h2>
					<table class="table table-striped">
						<thead>
							<tr><th>values</th><?php foreach($bloods as $bloodDate) { ?><th class="text-center"><?= $bloodDate['blood-date'] ?><br/><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_edit_blood/'.$cat['cat-hash'].'/'.$bloodDate['blood-date-url']) ?>">edit</a><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_del_blood_date/'.$cat['cat-hash'].'/'.$bloodDate['blood-date-url']) ?>">del</a></th><?php } ?></tr>
						</thead>
						<tbody>
							<tr><td>pictures</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"> <?php foreach($bloodDate['pictures'] as $picture) { ?> <atarget="_blank" href="<?= $picture['url'] ?>"><img  class="blood-pic-lnk" width="256" src="<?= $picture['url'] ?>" alt="blood picture"></a><br /><?php } ?></td> <?php } ?></tr>
							<tr><td>Red Cell Count (RBC)</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-red-cells'] ?></td><?php } ?></tr>
							<tr><td>Hematocrit</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-hematocrit'] ?></td><?php } ?></tr>
							<tr><td>Hemaglobin</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-hemaglobin'] ?></td><?php } ?></tr>
							<tr><td>White Cell Count (BWC)</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-white-cells'] ?></td><?php } ?></tr>
							<tr><td>Lymphocytes</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-lymphocytes'] ?></td><?php } ?></tr>
							<tr><td>Neutrophils</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-neutrophils'] ?></td><?php } ?></tr>
							<tr><td>Total Proteins</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-total-protein'] ?></td><?php } ?></tr>
							<tr><td>albumin</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-albumin'] ?></td><?php } ?></tr>
							<tr><td>globulin</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-globulin'] ?></td><?php } ?></tr>
							<tr><td>A:G Ratio</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?= $bloodDate['values']['cat-ag-ratio'] ?></td><?php } ?></tr>
							<tr><td>Total bilirubin</td><?php foreach($bloods as $bloodDate) { ?><td class="text-center"><?=$bloodDate['values']['cat-total-bilirubin'] ?></td><?php } ?></tr>
						</tbody>
					</table>
				<hr/>
				<a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_edit_blood/'.$cat['cat-hash']) ?>">new</a>
				
				
			
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
	</body>
</html>
