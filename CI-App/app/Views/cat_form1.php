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

	<script>

		function update_dose_indicator()
		{
			
			var checkedWet = $("#wet-block input[type=checkbox]:checked").length;
			var checkedNeuro = $("#neuro-block input[type=checkbox]:checked").length;
			var checkedOcular = $("#ocular-block input[type=checkbox]:checked").length;
			var dosage = 0;

			$('#fip-form-row').empty();

			if(checkedWet>0)
			{
				$('#fip-form-row').append('<div class="col"><div class="badge badge-pill badge-warning fip-type" id="wet-form" ><h4>wet</h4></div></div>');
				$("#effusion-block").css('display','block');
				
			}
			else
			{
				$("#effusion-block").css('display','none');
			}


			if(checkedNeuro>0)
				$('#fip-form-row').append('<div class="col"><div class="badge badge-pill badge-warning fip-type" id="neuro-form"><h4>neuro</h4></div></div>');

			if(checkedOcular>0)
				$('#fip-form-row').append('<div class="col"><div class="badge badge-pill badge-warning fip-type" id="ocular-form"><h4>ocular</h4></div></div>');


			if(checkedNeuro>0)
				dosage = 10;
			else if(checkedOcular>0)
				dosage = 8;
			else if(checkedWet>0)
				dosage = 5;

			if(dosage>0)
			{
				$('#fip-dose').css('display','block');
				$('#fip-dose-badge').html(dosage + ' ml/KG');
			}
			else
				$('#fip-dose').css('display','none');
		}

		


		

	</script>

		<div class="wrapper">
			<div class="container">
			<div class="logo">
				<img src="https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/82226910_10158057008452856_9021406031598583808_o.jpg?_nc_cat=110&_nc_oc=AQlUoMl5XBrtucjkDdzdEtuIfbiu_uRPBfVPwnTxxoFqJU3aZaZYptXIl88d_-2vbTQ&_nc_ht=scontent-cdg2-1.xx&oh=0a0830f5e9aaab4a11c094903888ad52&oe=5EA0C7BE" alt="header" />
			</div>
			</div>
			<div class="container">
			<h1>Welcome to FIP warrior data collection page</h1>

			<p> I am so sorry your sweet kitty is not well and that you needed to seek out this group. But welcome! For FIP you are in the right place for information and support.</p>
			<p>The admin team, volunteer vets and members in this group are nothing short of amazing!</p>
			<p>The FIP GS Warriors FAQ contains very important information, including the various treatment option brands and pricing. Please take a moment to read that - it is located here <a target="_blank" href="https://www.facebook.com/groups/158363205096283/permalink/314230959509506/"> Here's the link</a></p>
			<p>After reading the FAQ, please send a PM directly to one of the admins listed in the that document. If you are not sure which admin to PM just select the one geographically closest to you. I know this is scary and you are likely overwhelmed. But take a deep breath - we will get through this. My next comment will include several questions and additional information.</p>
			</div>
			<div class="container">
				if you already have a cat, please <a href="<?= site_url('MyCat/signin') ?>">sign in</a>
			</div>

			<div class="container-fluid">

			<h2>below is a form to fill your cat information</h2>

			<?php

			if(count($errors)>0)
			{
				echo '<span class="error">some required field are missing or incorrect</span>';
			}
			?>
		
			<form action="<?= site_url('Cat/review_step1'); ?>" method="POST">
				
				<?php if(array_key_exists('cat-hash',$inputs)) {?><input type="hidden" name="cat-hash" id="cat-hash" value="<?= $inputs['cat-hash'] ?>" /> <?php } ?>

					<div class="card">
					<div class="card-header">Parent's name</div>
					<div class="card-body">

						<?php if(array_key_exists('parent-first-name',$errors)){ echo '<span class="error">'.$errors['parent-first-name'].'</span>'; } ?>
						<div class="form-group ">
							<label for="parent-first-name" class="bmd-label-floating">First name</label><input type="text" class="form-control" name="parent-first-name" id="parent-first-name" value="<?= $inputs['parent-first-name'] ?>">
							<span class="bmd-help">Enter your first name.</span>
						</div>

						<?php if(array_key_exists('parent-last-name',$errors)){ echo '<span class="error">'.$errors['parent-last-name'].'</span>'; } ?>
						<div class="form-group ">
							<label for="parent-last-name" class="bmd-label-floating">Last name</label><input type="text" class="form-control" name="parent-last-name" id="parent-last-name"  value="<?= $inputs['parent-last-name'] ?>">
							<span class="bmd-help">Enter your last name.</span>
						</div>
					</div>
				    </div>


					<div class="card">
					<div class="card-header">Facebook name</div>
					<div class="card-body">
							<?php if(array_key_exists('fb-name',$errors)){ echo '<span class="error">'.$errors['fb-name'].'</span>'; } ?>
						<div class="form-group ">
							<label for="fb-name" class="bmd-label-floating">Facebook name</label><input type="text" class="form-control" name="fb-name" id="fb-name" value="<?= $inputs['fb-name'] ?>">
							<span class="bmd-help">Enter your facebook name.</span>
						</div>
					</div>
				    </div>

				
					<div class="card">
					<div class="card-header">Cat name</div>
					<div class="card-body">
						<?php if(array_key_exists('cat-name',$errors)){ echo '<span class="error">'.$errors['cat-name'].'</span>'; } ?>
						<div class="form-group ">
							<label for="cat-name" class="bmd-label-floating">Cat name</label><input type="text" class="form-control" name="cat-name" id="cat-name" value="<?= $inputs['cat-name'] ?>">
							<span class="bmd-help">Enter your cat's name.</span>
						</div>
					</div>
					</div>

					<div class="card">
					<div class="card-header">Cat's birth date</div>
					<div class="card-body">
						<?php if(array_key_exists('cat-birthdate',$errors)){ echo '<span class="error">'.$errors['cat-birthdate'].'</span>'; } ?>
			
						<div class="form-group">
							<p>Date: <input type="text" name="cat-birthdate" id="cat-birthdate" class="datetimepicker" data-date-format="M/D/Y" value="<?= $inputs['cat-birthdate'] ?>"></p>
						</div>
					

						<?php if(array_key_exists('cat-birthdate-exact',$errors)){ echo '<span class="error">'.$errors['cat-birthdate-exact'].'</span>'; } ?>
						<div class="form-group">
							<div class="radio"><label><input type="radio" name="cat-birthdate-exact" id="cat-birth-type-exact" value="exact" <?php if((array_key_exists('cat-birthdate-exact',$inputs))&&($inputs['cat-birthdate-exact']=='exact')){ echo 'checked'; } ?>>Exact</label></div>
							<div class="radio"><label><input type="radio" name="cat-birthdate-exact" id="cat-birth-type-approx" value="approx" <?php if((array_key_exists('cat-birthdate-exact',$inputs))&&($inputs['cat-birthdate-exact']=='approx')){ echo 'checked'; } ?>>Approximate</label></div>
							<span class="bmd-help">Specify if it's an exact date or approximate.</span>
						</div>
					

					</div>
					</div>

					<div class="card">
					<div class="card-header">Cat gender</div>
					<div class="card-body">
					<?php if(array_key_exists('cat-gender',$errors)){ echo '<span class="error">'.$errors['cat-gender'].'</span>'; } ?>
					<div class="form-group ">
						<div class="radio"><label><input type="radio" name="cat-gender" id="cat-gender-female" value="female" <?php if((array_key_exists('cat-gender',$inputs))&&($inputs['cat-gender']=='female')){ echo 'checked'; } ?> >Female</label></div>
						<div class="radio"><label><input type="radio" name="cat-gender" id="cat-gender-male" value="male" <?php if((array_key_exists('cat-gender',$inputs))&&($inputs['cat-gender']=='male')){ echo 'checked'; } ?>>Male</label></div>
						<span class="bmd-help">Select your cat's gender.</span>
					</div>
					</div>
					</div>

				
					<div class="card">
					<div class="card-header">Fixed/intact</div>
					<div class="card-body">
					<?php if(array_key_exists('cat-fixed',$errors)){ echo '<span class="error">'.$errors['cat-fixed'].'</span>'; } ?>
					<div class="form-group ">
						<div class="radio"><label><input type="radio" name="cat-fixed" id="cat-fixed" value="fixed" <?php if((array_key_exists('cat-fixed',$inputs))&&($inputs['cat-fixed']=='fixed')){ echo 'checked'; } ?>>fixed</label></div>
						<div class="radio"><label><input type="radio" name="cat-fixed" id="cat-intact" value="intact" <?php if((array_key_exists('cat-fixed',$inputs))&&($inputs['cat-fixed']=='intact')){ echo 'checked'; } ?>>intact</label></div>
						<span class="bmd-help">Select your cat's fixed status.</span>
					</div>
					</div>
					</div>
					
					<div class="card">
					<div class="card-header">Cat Breed</div>
					<div class="card-body">
						<?php if(array_key_exists('cat-breed',$errors)){ echo '<span class="error">'.$errors['cat-breed'].'</span>'; } ?>
						<div class="form-group ">
							<label for="cat-breed" class="bmd-label-floating">Cat Breed</label>
							<input type="text" class="form-control" name="cat-breed" id="cat-breed" value="<?= $inputs['cat-breed'] ?>">
							<span class="bmd-help">Enter your cat's breed.</span>
						</div>
					</div>
					</div>
			
					<div class="card">
					<div class="card-header">type of FIP</div>
					<div class="card-body">

						<?php if(array_key_exists('cat-symptoms',$errors)){ echo '<div class="row"><div class="col text-center"><span id="cat-symptoms-error" class="error">'.$errors['cat-symptoms'].'</span></div></div>'; } ?>
						
						<div class="row">
						<div class="col">
							<div class="container">
								<div class="row">
								<div class="col">
									<h3>General symptoms</h3>
									<?php if(array_key_exists('cat-misc',$errors)){ echo '<span id="cat-misc-error" class="error">'.$errors['cat-misc'].'</span>'; } ?>
									<div class="form-group">
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-fever"			value="fever"			<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('fever',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>fever</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-inappetence"	value="inappetence"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('inappetence',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>inappetence</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-lethargy"		value="lethargy"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('lethargy',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>lethargy</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-weight-loss"	value="weight-loss"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('weight-loss',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>weight loss</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-diarrhea"		value="diarrhea"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('diarrhea',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>diarrhea</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-constipation"	value="constipation"	<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('constipation',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>constipation</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-3rd-eyelid"		value="third-eyelid"	<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('third-eyelid',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>3rd eyelid protrusion</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-anemia"			value="anemia"			<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('anemia',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>anemia</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-PICA"			value="PICA"			<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('PICA',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>PICA (licking unusual objects)</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-jaundice"		value="jaundice"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('jaundice',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>jaundice</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-dark-urine"		value="dark-urine"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('dark-urine',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>dark/thick urine</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-misc[]" id="misc-eyes-change"	value="eyes-change"		<?php  if((array_key_exists('symptoms-misc',$symptoms))&&(array_search('eyes-change',$symptoms['symptoms-misc'])!==FALSE)){ echo 'checked'; } ?>>change in eye color affecting both eyes </label></div>
										<span class="bmd-help">Check box for your cat's additional symptoms.</span>
									</div>
									<h3>Other</h3>

									<?php if(array_key_exists('symptoms-misc-other',$errors)){ echo '<span class="error">'.$errors['symptoms-misc-other'].'</span>'; } ?>
									<div class="form-group ">
										<label for="symptoms-misc-other" class="bmd-label-floating">Other symptoms</label>
										<input type="text" class="form-control" name="symptoms-misc-other" id="symptoms-misc-other" value="<?= $symptoms['symptoms-misc-other'] ?>">
									</div>
								</div>
								<div class="col">
									<div id="wet-block">
										<h3>Wet form indicators</h3>
										<div class="form-group">
											<div class="checkbox"><label><input type="checkbox" name="symptoms-wet[]" id="symptoms-wet-potbellied"	value="potbellied"			<?php if((array_key_exists('symptoms-wet',$symptoms))&&(array_search('potbellied',$symptoms['symptoms-wet'])!==FALSE)){ echo 'checked'; } ?>>potbellied appearance</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-wet[]" id="symptoms-wet-labored"		value="labored-breathing"	<?php if((array_key_exists('symptoms-wet',$symptoms))&&(array_search('labored-breathing',$symptoms['symptoms-wet'])!==FALSE)){ echo 'checked'; } ?>>labored breathing</label></div>
											<span class="bmd-help">Select the symptoms for wet fip, .</span>
										</div>
									</div>
								</div>
								<div class="col">
									<div id="ocular-block">
										<h3>Ocular form indicators</h3>
										<div class="form-group">
											<div class="checkbox"><label><input type="checkbox" name="symptoms-ocular[]"	id="symptoms-ocular-uveitis"			value="uveitis"				<?php if((array_key_exists('symptoms-ocular',$symptoms))&&(array_search('uveitis',$symptoms['symptoms-ocular'])!==FALSE)){ echo 'checked'; } ?>>uveitis</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-ocular[]"	id="symptoms-ocular-keratic"			value="keratic"				<?php if((array_key_exists('symptoms-ocular',$symptoms))&&(array_search('keratic',$symptoms['symptoms-ocular'])!==FALSE)){ echo 'checked'; } ?>>keratic precipitates</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-ocular[]"	id="symptoms-ocular-aqueous"			value="aqueous"				<?php if((array_key_exists('symptoms-ocular',$symptoms))&&(array_search('aqueous',$symptoms['symptoms-ocular'])!==FALSE)){ echo 'checked'; } ?>>aqueous flare</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-ocular[]"	id="symptoms-ocular-eye-change"			value="one-eye-change"		<?php if((array_key_exists('symptoms-ocular',$symptoms))&&(array_search('one-eye-change',$symptoms['symptoms-ocular'])!==FALSE)){ echo 'checked'; } ?>>change in color of 1 eye</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-ocular[]"	id="symptoms-ocular-retinal"			value="retinal-cuffing"		<?php if((array_key_exists('symptoms-ocular',$symptoms))&&(array_search('retinal-cuffing',$symptoms['symptoms-ocular'])!==FALSE)){ echo 'checked'; } ?>>retinal vessel cuffing</label></div>
											<span class="bmd-help">For ocular fip, select the eyes symptoms.</span>
										</div>
									</div>
								</div>

								<div class="col">
									<div id="neuro-block">
										<h3>Neuro form indicators</h3>
										<div class="form-group">
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-ataxia"				value="ataxia"				<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('ataxia',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>ataxia (drunken/wobbly walk)</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-tremors"				value="tremors"				<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('tremors',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>tremors</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-seizures"			value="seizures"			<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('seizures',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>seizures flare</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-nystagmus"			value="nystagmus"			<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('nystagmus',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>nystagmus (darting eyes)</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-unequal-pupil"		value="unequal-pupil"		<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('unequal-pupil',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>unequal pupil size/shape</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-pupils-constrict"	value="no-pupils-constrict"	<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('no-pupils-constrict',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>pupils that do not constrict with light</label></div>
											<div class="checkbox"><label><input type="checkbox" name="symptoms-neuro[]"	id="symptoms-neuro-jump-reluctance"		value="jump-reluctance"		<?php if((array_key_exists('symptoms-neuro',$symptoms))&&(array_search('jump-reluctance',$symptoms['symptoms-neuro'])!==FALSE)){ echo 'checked'; } ?>>reluctance to jump to high places</label></div>
										
											<span class="bmd-help">Select the symptoms for neuro fip.</span>
										</div>
									</div>
								</div>
								
								
								</div>
								

								<!--
								<?php if(array_key_exists('symptoms-FIP',$errors)){ echo '<span id="symptoms-FIP-error" class="error">'.$errors['symptoms-FIP'].'</span>'; } ?>
								<div class="row">
								<div class="col">
									<h3>FIP type</h3>
									<div class="form-group">
										<div class="checkbox"><label><input type="checkbox" name="symptoms-FIP[]" id="FIP-wet"		value="wet"		<?php if((array_key_exists('symptoms-FIP',$symptoms))&&(array_search('wet'   ,$symptoms['symptoms-FIP'])!==FALSE)){ echo 'checked'; } ?> onclick="enable_effusion();" readonly>wet</label><span id="wet-indicator"></span></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-FIP[]" id="FIP-dry"		value="dry"		<?php if((array_key_exists('symptoms-FIP',$symptoms))&&(array_search('dry'   ,$symptoms['symptoms-FIP'])!==FALSE)){ echo 'checked'; } ?> readonly>	dry</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-FIP[]" id="FIP-neuro"	value="neuro"	<?php if((array_key_exists('symptoms-FIP',$symptoms))&&(array_search('neuro' ,$symptoms['symptoms-FIP'])!==FALSE)){ echo 'checked'; } ?>  readonly>neuro</label><span id="neuro-indicator"></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-FIP[]" id="FIP-ocular"	value="ocular"	<?php if((array_key_exists('symptoms-FIP',$symptoms))&&(array_search('ocular',$symptoms['symptoms-FIP'])!==FALSE)){ echo 'checked'; } ?> readonly>ocular</label><span id="ocular-indicator"></span></div>
										<span class="bmd-help">Select your cat's FIP type.</span>													  
									</div>
								</div>
								-->
								</div>
							</div>
						</div>
					</div>
					</div>

					<div class="jumbotron text-center">
						<div class="row">
						<div class="col">
							<div class="badge badge-pill badge-danger fip-type" id="fip-dose"><h4 id="fip-dose-badge"></h4></div> 
						</div>
						</div>

						<h2>FIP form</h2>

						<div class="row" id="fip-form-row">
						</div>

						<div class="row">
							<div class="col">
									<div id="effusion-block" <?php if((!array_key_exists('symptoms-FIP',$symptoms))||(array_search('wet',$symptoms['symptoms-FIP'])===FALSE)){ echo 'class="hidden"'; } ?>>
									<h3>Wet form type of effusion</h3>
									<div class="form-group">
										<div class="checkbox"><label><input type="checkbox" name="symptoms-effusion[]" id="symptoms-effusion-abdominal"	  value="abdominal"		<?php if((array_key_exists('symptoms-effusion',$symptoms))&&(array_search('abdominal',$symptoms['symptoms-effusion'])!==FALSE)){ echo 'checked'; } ?> >abdominal</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-effusion[]" id="symptoms-effusion-chest"		  value="chest"			<?php if((array_key_exists('symptoms-effusion',$symptoms))&&(array_search('chest',$symptoms['symptoms-effusion'])!==FALSE)){ echo 'checked'; } ?> >chest</label></div>
										<div class="checkbox"><label><input type="checkbox" name="symptoms-effusion[]" id="symptoms-effusion-pericardial" value="pericardial"	<?php if((array_key_exists('symptoms-effusion',$symptoms))&&(array_search('pericardial',$symptoms['symptoms-effusion'])!==FALSE)){ echo 'checked'; } ?> >pericardial</label></div>
							
										<span class="bmd-help">For wet fip, select the type of effusion.</span>
									</div>
								</div>
							</div>	
						</div>	
					</div>


					<div class="card">
					<div class="card-header">How has the diagnosis been made</div>
					<div class="card-body">
						<div class="form-group ">
							 <label for="cat-diagnosis" class="bmd-label-floating">Diagnosis</label>
							 <textarea class="form-control" name="cat-diagnosis" id="cat-diagnosis" rows="3" ><?= $inputs['cat-diagnosis'] ?></textarea>
							 <span class="bmd-help">Enter how your cat has been diagnosed.</span>
						</div>
					</div>
					</div>

					<div class="card">
					<div class="card-header">Diagnosis date</div>
					<div class="card-body">
						<?php if(array_key_exists('cat-diagnosis-date',$errors)){ echo '<span class="error">'.$errors['cat-diagnosis-date'].'</span>'; } ?>
						<div class="form-group ">
							<p>Diagnosis date: <input type="text" name="cat-diagnosis-date" id="cat-diagnosis-date" class="datetimepicker" data-date-format="M/D/Y" value="<?= $inputs['cat-diagnosis-date'] ?>"></p>
						</div>
					</div>
					</div>

					<div class="text-right"><input type="submit" name="submit" id="submit-btn" class="btn btn-primary" value="next"/></div>
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
		<script src="<?= base_url().'assets/js/plugins/moment.min.js'?>" ></script>
		<script src="<?= base_url().'assets/js/plugins/bootstrap-datetimepicker.js' ?>" ></script>
		

		<script>$( function() {
			
			$("#cat-birthdate").datetimepicker({format: 'M/D/Y'});
			$("#cat-diagnosis-date").datetimepicker({format: 'M/D/Y'});

			update_dose_indicator();
		

			$('#neuro-block input').click(function(){update_dose_indicator()});
			$('#ocular-block input').click(function(){update_dose_indicator()});
			$('#wet-block input').click(function(){update_dose_indicator()});
  } );</script>

	</body>
</html>
