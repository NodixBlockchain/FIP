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
			#wet-indicator, #neuro-indicator, #ocular-indicator
			{
				margin-left:8px;
			}
			.fip-type
			{
				padding:12px;
				min-width:96px;
			}
			#effusion-block div,label,input
			{
				display:inline-block;
			}
			#submit-btn
			{
				width:100%;
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
			<div class="container text-center">
			<h1>logged as <?= $infos['adm-username'] ?></h1>
			</div>

			<div class="container-fluid text-center">
				<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header"><h2>users</h2></div>
						<div class="card-body">users</div>
					</div>	
				</div>
				<div class="col">
					<div class="card">
						<div class="card-header"><h2>cats</h2></div>
						<div class="card-body"><a href="<?= site_url('Admin/cats') ?>" >cats</a></div>
					</div>	
				</div>
				<div class="col">
					<div class="card">
						<div class="card-header"><h2>admins</h2></div>
						<div class="card-body">admins</div>
					</div>	
				</div>
				</div>
			</div>

		</div>