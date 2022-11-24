<?php
require 'config.php';

//additional php code for this page goes here

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
	// var_dump($_POST);
	if ($stmt = $mysqli->prepare('SELECT `id`, `password` FROM `accounts` WHERE `username` = ?' )) {
		// data types: i = integer, s = string, d = double, b = blob
		$stmt->bind_param('s',$_POST['username']);
		// Execute Query
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows() > 0) {
			// That username already exists
			$userResponses[] = 'That username already exists, please choose another.';
		} else {
			// That username is availble so insert the record.
			if ($stmt = $mysqli->prepare('INSERT INTO `accounts` (`username`, `password`, `email`, `activation_code`) 
										  VALUES (?,?,?,?)')) {
				$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$activationCode = uniqid();
				$stmt->bind_param('ssss', $_POST['username'], $hash, $_POST['email'], $activationCode);
				$stmt->execute();
				
				// This is where it woould send an e-mail.
				var_dump($_POST);
				$activationLink = getMyUrl() . '/activate.php?email=' . $_POST['email'] . '&code=' . $activationCode;

				// echo($activationLink);
				$userResponses[] = 'Please click the following link to activate your account <a href="' . $activationLink . '">' . $activationLink . '</a>';
			} else {
				$userResponses[] = 'Could not insert into database';
			}
		}
	} else {
		$userResponses[] = 'Could not prepate the SELECT statement';
	}
}

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>
<!-- Error Handling -->
	<?php if ($userResponses): ?>
	<p class="notification is-danger is-light">
		<?php echo implode('<br>', $userResponses);
			// echo '<br>';
			// var_dump($_POST); ?>
	</p>
<?php endif; ?>
<!-- START PAGE CONTENT -->
	<h1 class="title">Register</h1>

	<form action="" method="post">

		<!-- Username Field -->
		<div class="field">
			<label class="label">Username</label>
			<div class="control has-icons-left">
				<input name="username" class="input" type="text" placeholder="LeeroyJenkins" required>
				<span class="icon is-left"><i class="fas fa-user"></i></span>
			</div>
		</div>

		<!-- Password Field -->
		<div class="field">
			<label class="label">Password</label>
			<div class="control has-icons-left">
				<input name="password" class="input" type="password" placeholder="Type your password here." required>
				<span class="icon is-left"><i class="fas fa-lock"></i></span>
			</div>
		</div>

		<!-- Email Field -->
		<div class="field">
			<label class="label">Email</label>
			<div class="control has-icons-left">
				<input name="email" class="input" type="email" placeholder="leeroyjenkins247@gmail.com" required>
				<span class="icon is-left"><i class="fas fa-envelope"></i></span>
			</div>
		</div>
		
		<div class="field is-grouped">
			<div class="control">
				<button name="send" type="submit" class="button is-link" >
					Register
					<!-- <a href="activate.php"></a> -->
				</button>
			</div>
		</div>
	</form>
	<!-- END PAGE CONTENT -->

<?= template_footer() ?>