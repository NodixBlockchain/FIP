<!doctype html>
<html>
	<head>
		<title>Welcome to FIP warrior data collection</title>
		
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
		</style>

	</head>
	<body>

	<script>
	
		function get_timezone()
		{	
			
			var tz = moment.tz.guess();

			var timezones = moment.tz.names();

			

			for(var i=0;i<timezones.length;i++)
			{
				$('#user-timezone').append('<option value="'+timezones[i]+'">'+timezones[i]+'</option>')
			
			}
			$('#user-timezone option[value="'+tz+'"]').prop('selected', true); 
			
			
		}
	</script>

		<div class="wrapper">
			<div class="container">
			<div class="logo">
				<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
			</div>
			</div>

			<div class="container">
				<div class="jumbotron text-left"><a href="<?= site_url('cat/index/'.$catHash) ?>" >home</a> / register</div>
			</div>

			<div class="container">
				<h2>Below are your identification information</h2>
				<form action="<?= site_url('Cat/do_register/'.$catHash) ?>" method="POST">

				<?php if(array_key_exists('user-email',$errors)){ echo '<span id="user-email-error" class="error">'.$errors['user-email'].'</span>'; } ?>
				<div class="form-group ">
					<label for="user-email" class="bmd-label-floating">email</label><input type="text" class="form-control" name="user-email" id="user-email" value="<?= $infos['user-email'] ?>">
					<span class="bmd-help">Enter your email.</span>
				</div>

				<?php if(array_key_exists('user-pw',$errors)){ echo '<span id="user-pw-error" class="error">'.$errors['user-pw'].'</span>'; } ?>
				<div class="form-group ">
					<label for="user-pw" class="bmd-label-floating">password</label><input type="password" class="form-control" name="user-pw" id="user-pw" value="<?= $infos['user-pw'] ?>">
					<span class="bmd-help">Enter your password.</span>
				</div>
				<?php if(array_key_exists('user-pw2',$errors)){ echo '<span id="user-pw2-error" class="error">'.$errors['user-pw2'].'</span>'; } ?>
				<div class="form-group ">
					<label for="user-pw2" class="bmd-label-floating">confirm password</label><input type="password" class="form-control" name="user-pw2" id="user-pw2"  value="<?= $infos['user-pw2'] ?>">
					<span class="bmd-help">Confirm your password.</span>
				</div>
				<div class="form-group">
					<label for="user-weight-unit">Weight unit</label>
					<div class="radio"><label><input type="radio" name="user-weight-unit" id="user-weight-unit-kg" value="kg" <?php if((array_key_exists('user-weight-unit',$infos))&&($infos['user-weight-unit']=='kg')){ echo 'checked'; } ?>>KG</label></div>
					<div class="radio"><label><input type="radio" name="user-weight-unit" id="user-weight-unit-pnd" value="pnd" <?php if((array_key_exists('user-weight-unit',$infos))&&($infos['user-weight-unit']=='pnd')){ echo 'checked'; } ?>>Pound</label></div>
					<span class="bmd-help">Specify The unit used for weight.</span>
				</div>
				<div class="form-group">
					<label for="user-temp-unit">Temperature unit</label>
					<div class="radio"><label><input type="radio" name="user-temp-unit" id="user-temp-unit-celsius" value="celsius" <?php if((array_key_exists('user-temp-unit',$infos))&&($infos['user-temp-unit']=='celsius')){ echo 'checked'; } ?>>celsius</label></div>
					<div class="radio"><label><input type="radio" name="user-temp-unit" id="user-temp-unit-fahrenheit" value="fahrenheit" <?php if((array_key_exists('user-temp-unit',$infos))&&($infos['user-temp-unit']=='fahrenheit')){ echo 'checked'; } ?>>fahrenheit</label></div>
					<span class="bmd-help">Specify The unit used for temperature.</span>
				</div>

				<div class="form-group">
					<label for="user-timezone">Timezone</label>

					<select id="user-timezone" name="user-timezone" class="form-control" >
					</select>

					<span class="bmd-help">Specify your timezone.</span>
				</div>


				<div class="row">
					<div class="col text-left"><a class="btn btn-primary" href="<?= site_url('Cat/review_step6/'. $catHash) ?>">back</a></div>
					<div class="col text-right"><input class="btn btn-primary" type="submit" value="register cat"/></div>
				</div>

				
				</form>
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
			<div class="row"><div class="col">type of FIP</div><div class="col">

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
			<div class="row"><div class="col">diagnosis</div><div class="col"><?= $inputs['cat-diagnosis'] ?> </div></div>
			<div class="row"><div class="col">diagnosis date</div><div class="col"><?= $inputs['cat-diagnosis-date'] ?> </div></div>
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

			get_timezone();
   
		  } );
		</script>

	</body>
</html>
