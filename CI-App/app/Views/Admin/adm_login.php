<!doctype html>
<html>
	<head>
		<title>Welcome to FIP warrior data collection</title>
		<meta charset="ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" type="text/css" href="<?= base_url().'assets/css/material-kit.min.css' ?>" />
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

		<div class="wrapper">
			<div class="container">
			<div class="logo">
				<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
			</div>
			</div>
			<div class="container">
				<?php if($loginError) { echo '<span class="error">invalid username or password</span>'; } ?>

				<h2>Enter your admin identifier</h2>
				<form action="<?= site_url('Admin/do_login') ?>" method="POST">

				<div class="form-group ">
					<?php if(array_key_exists('adm-username',$errors)){ echo '<span id="adm-username-error" class="error">'.$errors['adm-username'].'</span>'; } ?>
					<label for="adm-email" class="bmd-label-floating">username</label><input type="text" class="form-control" name="adm-username" id="adm-username" value="<?= $infos['adm-username'] ?>">
					<span class="bmd-help">Enter your admin identifier.</span>
				</div>
				<div class="form-group ">
					<?php if(array_key_exists('adm-pw',$errors)){ echo '<span id="adm-pw-error" class="error">'.$errors['adm-pw'].'</span>'; } ?>
					<label for="adm-pw" class="bmd-label-floating">password</label><input type="password" class="form-control" name="adm-pw" id="adm-pw" value="<?= $infos['adm-pw'] ?>">
					<span class="bmd-help">Enter your password.</span>
				</div>
				
				<input class="btn btn-primary" type="submit" value="login"/>
				</form>
			</div>

			<div class="col"><a class="btn btn-primary" href="<?= base_url() ?>" >home</a></div>

			<div class="footer">
				Page rendered in {elapsed_time} seconds. Environment: <?= ENVIRONMENT ?>
			</div>

		</div>

		<script src="<?= base_url().'assets/js/core/jquery.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/core/popper.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/core/bootstrap-material-design.min.js' ?>" ></script>
		<script src="<?= base_url().'assets/js/material-kit.min.js' ?>" ></script>
		

	</body>
</html>
