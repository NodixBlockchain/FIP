<!doctype html>
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
		</style>

	</head>
	<body>	<!-- Sidebar -->
		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
			<a class="navbar-brand" href="<?= base_url(); ?>">FIP Warrior</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
  			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item"><a class="nav-link"  href="<?= site_url('MyCat/my_infos') ?>">My infos</a></a></li>
				  <li class="nav-item active"><a class="nav-link" href="<?= site_url('MyCat/index') ?>">My cats</a></li>
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
				<h2>below is a list of your cats</h2>

				<?php foreach($cats as $cat) { ?>
						
						<div class="card">
						<div class="card-header text-center">
							<h3><?= $cat['cat-name'] ?>
							<br/>
							<?= $cat['cat-birthdate'] ?><?php if($cat['cat-birthdate-exact'] == 'approx'){ echo " (approximate) "; } ?></h3>
						</div>
						<div class="card-body text-center"><img width="256" src="<?= $cat['picture'] ?>" alt="cat picture"><br/><a class="btn btn-primary" href="<?php echo site_url('MyCat/my_cat/'.$cat['cat-hash']); ?>" >More infos</a> </div>
						<div class="card-footer text-center">
							<div class="container">
							<div class="row">
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_infos/'.$cat['cat-hash']) ?>" >Metrics</a></div>
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_symptoms/'.$cat['cat-hash']) ?>" >Symptoms</a></div>
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_blood/'.$cat['cat-hash']) ?>" >Bloods</a></div>
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_eyes/'.$cat['cat-hash']) ?>" >Eyes</a></div>
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_xrays/'.$cat['cat-hash']) ?>" >Xrays</a></div>
							<div class="col"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_echographies/'.$cat['cat-hash']) ?>" >Echographies</a></div>
							</div>
							</div>
						</div>
					</div>
				<?php } ?>

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
