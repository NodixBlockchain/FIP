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
			.fip-type
			{
				padding:12px;
				min-width:96px;
			}
			.date
			{
				background-color:rgba(0,0,0,0.3);
			}
		</style>

	</head>
	<body>

		<div class="wrapper">
			<div class="container">
			<div class="logo">
				<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
			</div>
			</div>

			<div class="container">
				<div class="jumbotron text-left"><a href="<?= site_url('cat/index/'.$catHash) ?>" >home</a> / information review</div>
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

			<div class="container">
			<h2>symptoms</h2>
				<div class="row">
				<?php if(count($symptoms['symptoms-misc'])>0) { ?>
					<div class="col text-left">
						<h3>general</h3>
						<ul>
						<?php foreach($symptoms['symptoms-misc'] as $symptom) { ?>
							<li><?= $symptom ?></li>
						<?php } ?>

						<?php if($symptoms['symptoms-misc-other']) { ?>
								<li><?= $symptoms['symptoms-misc-other'] ?></li>
						<?php } ?>
						</ul>
					</div>
				<?php } ?>
				</div>
				<div class="row">
				<?php if(count($symptoms['symptoms-wet'])>0) { ?>
					<div class="col text-left">
						<div class="badge badge-pill badge-warning fip-type">
						<h4>wet</h4>
						<?php 
							if(count($symptoms['symptoms-effusion'])>0)
							{
								$first = 1;
								foreach($symptoms['symptoms-effusion'] as $effusion)
								{
									if($first==0)
										echo '<br/>';

									echo $effusion;
									$first=0;
								}
							}
							else
							{
								echo "unspecified";
							}
						?>						
						
						</div>
						<ul> <?php foreach($symptoms['symptoms-wet'] as $symptom) { ?> <li><?= $symptom ?></li> <?php } ?> </ul>
					</div>
				<?php } ?>

				<?php if(count($symptoms['symptoms-ocular'])>0) { ?>
					<div class="col text-left">					
						<div class="badge badge-pill badge-warning fip-type"><h4>ocular</h4></div>
						<ul><?php foreach($symptoms['symptoms-ocular'] as $symptom) { ?> <li><?= $symptom ?></li> <?php } ?> </ul>
					</div>
				<?php } ?>

				<?php if(count($symptoms['symptoms-neuro'])>0) { ?>
					<div class="col text-left">
						<div class="badge badge-pill badge-warning fip-type"><h4>neuro</h4></div>
						<ul> <?php foreach($symptoms['symptoms-neuro'] as $symptom) { ?> <li><?= $symptom ?></li> <?php } ?> </ul>
					</div>
				<?php } ?>
			</div>
		</div>

		<hr/>

		<div class="container">
			<div class="row">
			<?php if(array_search('ocular',$symptoms['symptoms-FIP'] )) { ?>
				<div class="col text-center">
				<?php if(count($eyes)>0) { ?>
					<h2>Eyes picture</h2>
					<div id="carousel-eyes-pics" class="carousel slide" data-ride="carousel"  data-interval="false">
			  
					  <ol class="carousel-indicators">
						<?php $n=0; $active = 'active';  foreach($eyes as $picture) { ?>
							<li data-target="#carousel-eyes-pics" data-slide-to="<?= $n ?>" class="<?= $active ?>"></li>
						<?php $n++; $active = ''; } ?>
					  </ol>

					  <div class="carousel-inner">
						<?php $active = 'active';  foreach($eyes as $picture) { ?>
							<div class="carousel-item <?= $active ?>">
								<img class="d-block w-100" src="<?= $picture['url'] ?>" alt="eyes picture" />
								<div class="carousel-caption"><p class="date">date : <?= $picture['date'] ?></p></div>
							</div>
						<?php $active = ''; } ?>
					  </div>
					  <a class="carousel-control-prev" href="#carousel-eyes-pics" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carousel-eyes-pics" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				<?php }	else { ?>
					<h2>no eyes picture</h2>
				<?php } ?>
				</div>
			<?php } ?>
			<div class="col text-center">
				<?php if(count($eyes)>0) { ?>
					<h2>Cat's pictures</h2>
					<div id="carousel-cat-pics" class="carousel slide" data-ride="carousel" data-interval="false">
			  
					  <ol class="carousel-indicators">
						<?php $n=0; $active = 'active';  foreach($pictures as $picture) { ?>
							<li data-target="#carousel-cat-pics" data-slide-to="<?= $n ?>" class="<?= $active ?>"></li>
						<?php $n++; $active = ''; } ?>
					  </ol>

					  <div class="carousel-inner">
						<?php $active = 'active';  foreach($pictures as $picture) { ?>
							<div class="carousel-item <?= $active ?>">
								<img class="d-block w-100" src="<?= $picture['url'] ?>" alt="cat picture" />
							</div>
						<?php $active = ''; } ?>
					  </div>
					  <a class="carousel-control-prev" href="#carousel-cat-pics" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carousel-cat-pics" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				<?php }	else { ?>
					<h2>No cat picture</h2>
				<?php } ?>
			</div>
			<hr/>
			<div class="row">
			<div class="col text-center">
				<?php if(count($xrays)>0) { ?>
					<h2>xrays</h2>
					<div id="carousel-xrays-pics" class="carousel slide" data-ride="carousel" data-interval="false">
			  
					  <ol class="carousel-indicators">
						<?php $n=0; $active = 'active';  foreach($xrays as $picture) { ?>
							<li data-target="#carousel-xrays-pics" data-slide-to="<?= $n ?>" class="<?= $active ?>"></li>
						<?php $n++; $active = ''; } ?>
					  </ol>

					  <div class="carousel-inner">
						<?php $active = 'active';  foreach($xrays as $picture) { ?>
							<div class="carousel-item <?= $active ?>">
								<img class="d-block w-100" src="<?= $picture['url'] ?>" alt="cat xray">
								<div class="carousel-caption"><p class="date">date : <?= $picture['date'] ?> </p></div>
							</div>
						<?php $active = ''; } ?>
					  </div>
					  <a class="carousel-control-prev" href="#carousel-xrays-pics" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carousel-xrays-pics" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				<?php }	else { ?>
					<h2>no xrays</h2>
				<?php } ?>
			</div>
		
			<div class="col text-center">
				<?php if(count($echographies)>0) { ?>
					<h2>echography</h2>
					<div id="carousel-echo-pics" class="carousel slide" data-ride="carousel" data-interval="false">
			  
					  <ol class="carousel-indicators">
						<?php $n=0; $active = 'active';  foreach($echographies as $picture) { ?>
							<li data-target="#carousel-echo-pics" data-slide-to="<?= $n ?>" class="<?= $active ?>"></li>
						<?php $n++; $active = ''; } ?>
					  </ol>

					  <div class="carousel-inner">
						<?php $active = 'active';  foreach($echographies as $picture) { ?>
							<div class="carousel-item <?= $active ?>">
								<img class="d-block w-100" src="<?= $picture['url'] ?>" alt="cat echography">
								<div class="carousel-caption"><p class="date">date : <?= $picture['date'] ?> </p></div>
							</div>
						<?php $active = ''; } ?>
					  </div>
					  <a class="carousel-control-prev" href="#carousel-echo-pics" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carousel-echo-pics" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				<?php }	else { ?>
					<h2>no echography</h2>
				<?php } ?>
			</div>
			</div>
			<hr/>
			<div class="row">
			<div class="col text-center">
			<h2>blood</h2>
			<?php if($has_blood) { ?>
				
				<div class="row">
				<?php foreach($blood as $picture) { ?>
						<div class="col">
							<a target="_blank" href="<?= $picture['url'] ?>"><img width="256" src="<?= $picture['url'] ?>" alt="cat blood"></a>
							<div class="date">date :<?= $picture['date'] ?></div>
						</div>
				<?php } ?>
			
				</div>


				<h2>blood values</h2>
			
				<div class="row"><div class="col">Red Cell Count (RBC)</div><div class="col"><?= $blood_vals['cat-red-cells'] ?></div></div>
				<div class="row"><div class="col">Hematocrit</div><div class="col"><?= $blood_vals['cat-hematocrit'] ?></div></div>
				<div class="row"><div class="col">Hemaglobin</div><div class="col"><?= $blood_vals['cat-hemaglobin'] ?></div></div>
				<div class="row"><div class="col">White Cell Count (BWC)</div><div class="col"><?= $blood_vals['cat-white-cells'] ?></div></div>
				<div class="row"><div class="col">Lymphocytes</div><div class="col"><?= $blood_vals['cat-lymphocytes'] ?> </div></div>
				<div class="row"><div class="col">Neutrophils</div><div class="col"><?= $blood_vals['cat-neutrophils'] ?> </div></div>
				<div class="row"><div class="col">Total Proteins</div><div class="col"><?= $blood_vals['cat-total-protein'] ?> </div></div>
				<div class="row"><div class="col">albumin</div><div class="col"><?= $blood_vals['cat-albumin'] ?> </div></div>
				<div class="row"><div class="col">globulin</div><div class="col"><?= $blood_vals['cat-globulin'] ?> </div></div>
				<div class="row"><div class="col">A:G Ratio</div><div class="col"><?= $blood_vals['cat-ag-ratio'] ?> </div></div>
				<div class="row"><div class="col">Total bilirubin</div><div class="col"><?= $blood_vals['cat-total-bilirubin'] ?> </div></div>
			<?php } else { ?>
				<p>no blood infos</p>
			<?php } ?>
		</div>


		<div class="container">
			<div class="row">
				<?php if($has_blood) { ?>
					<div class="col text-left"><a class="btn btn-primary" href="<?= site_url('Cat/review_step5/'.$catHash) ?>">back</a></div>
				<?php } else { ?>	
					<div class="col text-left"><a class="btn btn-primary" href="<?= site_url('Cat/review_step4/'.$catHash) ?>">back</a></div>
				<?php } ?>

				<div class="col text-right"><a class="btn btn-primary" href="<?= site_url('Cat/register/'.$catHash) ?>">next</a></div>
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
	</body>
</html>
