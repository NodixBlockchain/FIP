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
			#blood-form-load
			{
				display:none;
			}
			.wrapper
			{
				margin-top: 64px;
			}
		</style>

	</head>
	<body>	
		<script>
			function upload_blood()
			{
				$('#blood-form-load').css('display','inline'); 
				$('#blood-form-submit').prop('disabled','disabled'); 
				$('#blood-form').submit();
			}

		</script>
	
		<!-- Sidebar -->
		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
			<a class="navbar-brand" href="<?= base_url(); ?>">FIP Warrior</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
  			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item active"><a class="nav-link"  href="<?= site_url('MyCat/my_infos') ?>">My infos</a></a></li>
				  <li class="nav-item"><a class="nav-link" href="<?= site_url('MyCat/index') ?>">My cats</a></li>
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

			<div class="container text-center"><h1>Blood for <?= $blood['blood-date'] ?></h1></div>
			<div class="container">
			<h2>Upload blood panel picture if you have them</h2>

		
			
			<?php if(array_key_exists('cat-blood',$errors)) { echo '<div class="container"><span class="error text-center">'.$errors['cat-blood'].'</span></div>'; } ?>

			<form action="<?= site_url('MyCat/add_blood_pic/'.$cat['cat-hash']) ?>" method="POST" id="blood-form" enctype="multipart/form-data">
				<input type="hidden" name="blood-date" id="blood-date" value="<?= $blood['blood-date'] ?>">


				<div class="card">
					<div class="card-header text-center"><h3>Upload blood panels</h3><br/>
					<img id="blood-form-load" width="64" src="<?= base_url().'assets/img/loading.gif' ?>" alt="loading" /></div>
					<div class="card-body">
						<div class="input-group mb-3">
						  <div class="custom-file">
						   <input onchange=" upload_blood(); " type="file" class="custom-file-input" name="cat-blood" id="cat-blood">
						   <label for="cat-blood" class="custom-file-label">Select a picture for cat's blood panels</label> 
						  </div>
						</div>
					</div>
					<input type="submit" class="btn btn-primary" value="upload" accept="image/*" id="blood-form-submit"/>
				 </div>
			</form>
			<div class="row">
			<?php foreach($blood['pictures'] as $picture) { ?>
				<div class="col text-center">
					<a target="_blank" href="<?= $picture['url'] ?>"><img width="256" src="<?= $picture['url'] ?>" alt="cat blood"></a>
					<div class="date">date : <?= $picture['date'] ?></div>
					<form action="<?= site_url('MyCat/delbloodpic/'.$cat['cat-hash'].'/'.$picture['file']) ?>" method="POST">
						<input type="submit" value="del" class="btn btn-primary" />
					</form>
				</div>
			<?php } ?>
			</div>

			<form action="<?= site_url('MyCat/add_blood_vals/'.$cat['cat-hash']) ?> " method="POST" >
				<input type="hidden" name="blood-date" id="blood-date" value="<?= $blood['blood-date'] ?>">
				<div class="card">
					<div class="card-header">Red cells</div>
					<div class="card-body">
					<h3>Red blood cells</h3>
						<div class="form-group ">

							<?php if(array_key_exists('cat-red-cells',$errors)){ echo '<span id="cat-red-cells-error" class="error">'.$errors['cat-red-cells'].'</span>'; } ?>

							<label for="cat-red-cells" class="bmd-label-floating">Red cells (RBC)</label>
							<input type="text" class="form-control" name="cat-red-cells" id="cat-red-cells" value="<?= $blood['values']['cat-red-cells'] ?>">mg/µL
							<span class="bmd-help">Enter RBC.</span>
						</div>
						<div class="form-group ">

							<?php if(array_key_exists('cat-hematocrit',$errors)){ echo '<span id="cat-hematocrit-error" class="error">'.$errors['cat-hematocrit'].'</span>'; } ?>

							<label for="cat-hematocrit" class="bmd-label-floating">Hematocrit (HCT)</label>
							<input type="text" class="form-control" name="cat-hematocrit" id="cat-hematocrit"  value="<?= $blood['values']['cat-hematocrit'] ?>">%
							<span class="bmd-help">Enter Hematocrit.</span>
						</div>
						<div class="form-group ">

							<?php if(array_key_exists('cat-hemaglobin',$errors)){ echo '<span id="cat-hemaglobin-error" class="error">'.$errors['cat-hemaglobin'].'</span>'; } ?>

							<label for="cat-hemaglobin" class="bmd-label-floating">hemaglobin (HBG)</label>
							<input type="text" class="form-control" name="cat-hemaglobin" id="cat-hemaglobin"  value="<?= $blood['values']['cat-hemaglobin'] ?>">g/dL
							<span class="bmd-help">Enter hemaglobin.</span>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">White cells</div>
					<div class="card-body">
					<h3>White cells</h3>
						<div class="form-group ">
							<?php if(array_key_exists('cat-white-cells',$errors)){ echo '<span id="cat-white-cells-error" class="error">'.$errors['cat-white-cells'].'</span>'; } ?>

							<label for="cat-white-cells" class="bmd-label-floating">White blood cells (WBC)</label>
							<input type="text" class="form-control" name="cat-white-cells" id="cat-white-cells" value="<?= $blood['values']['cat-white-cells'] ?>">K/µL
							<span class="bmd-help">Enter WBC.</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-lymphocytes',$errors)){ echo '<span id="cat-lymphocytes-error" class="error">'.$errors['cat-lymphocytes'].'</span>'; } ?>
							<label for="cat-lymphocytes" class="bmd-label-floating">% Lymphocytes (%LYM)</label>
							<input type="text" class="form-control" name="cat-lymphocytes" id="cat-lymphocytes"  value="<?= $blood['values']['cat-lymphocytes'] ?>">%
							<span class="bmd-help">Enter %LYM.</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-neutrophils',$errors)){ echo '<span id="cat-neutrophils-error" class="error">'.$errors['cat-neutrophils'].'</span>'; } ?>
							<label for="cat-neutrophils" class="bmd-label-floating">% Neutrophils (%NEU)</label>
							<input type="text" class="form-control" name="cat-neutrophils" id="cat-neutrophils"  value="<?= $blood['values']['cat-neutrophils'] ?>">%
							<span class="bmd-help">Enter %NEU.</span>
						</div>
					</div>
				</div>

				<div class="card">	
					<div class="card-header">Chemistry</div>
					<div class="card-body">
					<h3>Chemistry</h3>
						<div class="form-group ">
							<?php if(array_key_exists('cat-total-protein',$errors)){ echo '<span id="cat-total-protein-error" class="error">'.$errors['cat-total-protein'].'</span>'; } ?>
							<label for="cat-total-protein" class="bmd-label-floating">Total protein (TBC)</label>
							<input type="text" class="form-control" name="cat-total-protein" id="cat-total-protein" value="<?= $blood['values']['cat-total-protein'] ?>">g/dL
							<span class="bmd-help">Enter TBC.</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-albumin',$errors)){ echo '<span id="cat-albumin-error" class="error">'.$errors['cat-albumin'].'</span>'; } ?>
							<label for="cat-albumin" class="bmd-label-floating">Albumin (ALB)</label>
							<input type="text" class="form-control" name="cat-albumin" id="cat-albumin"  value="<?= $blood['values']['cat-albumin'] ?>">g/dL
							<span class="bmd-help">Enter ALB.</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-globulin',$errors)){ echo '<span id="cat-globulin-error" class="error">'.$errors['cat-globulin'].'</span>'; } ?>
							<label for="cat-globulin" class="bmd-label-floating">Globulin (GLOB)</label>
							<input type="text" class="form-control" name="cat-globulin" id="cat-globulin"  value="<?= $blood['values']['cat-globulin'] ?>">g/dL
							<span class="bmd-help">Enter GLOB.</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-ag-ratio',$errors)){ echo '<span id="cat-ag-ratio-error" class="error">'.$errors['cat-ag-ratio'].'</span>'; } ?>
							<label for="cat-ag-ratio" class="bmd-label-floating">Albumin/Globulin (A/G)</label>
							<input type="text" class="form-control" name="cat-ag-ratio" id="cat-ag-ratio"  value="<?= $blood['values']['cat-ag-ratio'] ?>">
							<span class="bmd-help">Enter (A/G).</span>
						</div>
						<div class="form-group ">
							<?php if(array_key_exists('cat-total-bilirubin',$errors)){ echo '<span id="cat-total-bilirubin-error" class="error">'.$errors['cat-total-bilirubin-ratio'].'</span>'; } ?>
							<label for="cat-total-bilirubin" class="bmd-label-floating">Total Bilirubin (TBIL)</label>
							<input type="text" class="form-control" name="cat-total-bilirubin" id="cat-total-bilirubin"  value="<?= $blood['values']['cat-total-bilirubin'] ?>">mh/dL
							<span class="bmd-help">Enter (TBIL).</span>
						</div>

					</div>
				</div>
				
				<div class="row">
					<div class="col text-left"><a class="btn btn-primary" href="<?= site_url('MyCat/my_cat_blood/'.$cat['cat-hash']) ?>">cancel</a></div>
					<div class="col text-right"><input type="submit" class="btn btn-primary" value="submit"></div>
				</div>

			</form>
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
		<script src="<?= base_url().'assets/js/plugins/moment.min.js' ?>"></script>
		<script src="<?= base_url().'assets/js/plugins/moment-timezone-with-data.js' ?>"></script>		

		<script>$( function() {

			get_timezone('<?= $infos['user-timezone'] ?>');
   
		  } );
		</script>
		   
		
		
	
	</body>
</html>
