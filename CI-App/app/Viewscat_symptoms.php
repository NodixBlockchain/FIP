<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Welcome to FIP warrior data collection</title>
		
		
		<script src="/public/assets/js/core/jquery.min.js" ></script>
		<script src="/public/assets/js/core/popper.min.js" ></script>
		<script src="/public/assets/js/core/bootstrap-material-design.min.js" ></script>
		<script src="/public/assets/js/material-kit.min.js" ></script>
		<script src="/public/assets/js/core/jquery-ui.js"></script>

		
		  
		
		<link rel="stylesheet" type="text/css" href="/public/assets/css/material-kit.min.css" />
		<link rel="stylesheet" type="text/css" href="/public/assets/css/jquery-ui.css">
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
		</style>

	</head>
	<body>	<!-- Sidebar -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<a class="navbar-brand" href="<?= site_url('cat/index') ?>">FIP warrior home</a>
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				  <li class="nav-item active"><a class="nav-link" href="<?= site_url('cat/my_cats') ?>">My cats</a></li>

				  <li class="nav-item"><a class="nav-link" href="<?php echo site_url('cat/my_cat_blood/'.$cat['cat-hash']); ?>" >Bloods</a></li>
				  <li class="nav-item"><a class="nav-link" href="<?php echo site_url('cat/my_cat_eyes/'.$cat['cat-hash']); ?>" >Eyes</a></li>
				  <li class="nav-item"><a class="nav-link" href="<?php echo site_url('cat/my_cat_xrays/'.$cat['cat-hash']); ?>" >Xrays</a></li>
				  <li class="nav-item"><a class="nav-link" href="<?php echo site_url('cat/my_cat_echographies/'.$cat['cat-hash']); ?>" >Echographies</a></li>

				  <li class="nav-item"><a class="nav-link"  href="<?= site_url('cat/signout') ?>">Sign out</a></a></li>
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
			</div>
			<hr/>

			<div class="container">
				<h2>symptoms</h2>
				<div class="row"><div class="col">
				<ul>
				<?php
					foreach($symptoms['symptoms-FIP'] as $FIP)
					{
						echo '<li>';
						echo $FIP;

						if($FIP=='wet'){

							if(count($symptoms['symptoms-effusion'])>0)
							{
								$first=1;
								echo '(';

								foreach($symptoms['symptoms-effusion'] as $effusion)
								{
									if($first==0)
										echo ',';

									echo $effusion;
									$first=0;
								}

								echo ')';
							}
							else
							{
								echo "(unspecified)";
							}
						}
						echo '</li>';
					}
				?>
				</ul>
				</div></div>


				<div class="row">
					<div class="col text-left">
						<h3>general</h3>
						<ul>
						<?php foreach($symptoms['symptoms-misc'] as $symptom) { ?>
							<li><?= $symptom ?></li>
						<?php } ?>
						</ul>
					</div>
					<div class="col text-left">
						<h3>wet</h3>
						<ul>
						<?php foreach($symptoms['symptoms-wet'] as $symptom) { ?>
							<li><?= $symptom ?></li>
						<?php } ?>
						</ul>
					</div>
					<div class="col text-left">
						<h3>neuro</h3>
						<ul>
						<?php foreach($symptoms['symptoms-neuro'] as $symptom) { ?>
							<li><?= $symptom ?></li>
						<?php } ?>
						</ul>
					</div>
					<div class="col text-left">					
						<h3>ocular</h3>
						<ul>
						<?php foreach($symptoms['symptoms-ocular'] as $symptom) { ?>
							<li><?= $symptom ?></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<hr/>


			<div class="container text-center">
			<h2>Pictures of your cat</h2>
			<div class="row">
				<?php foreach($cat['pictures'] as $picture) { ?>
					<div class="col"><img width="256" src="<?= $picture['url'] ?>" alt="cat picture"></div>
				<?php } ?>

				?>
			</div>
		</div>

		   
		<div class="footer">
			Page rendered in {elapsed_time} seconds. Environment: <?= ENVIRONMENT ?>
		</div>

		</div>
		
	</body>
</html>
