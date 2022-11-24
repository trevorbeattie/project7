<?php
require 'config.php';
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$_SESSION['active_page'] = $activePage;
//https://icarus.cs.weber.edu/~tb73309/web3400/project3a/login.php

//additional php code for this page goes here
//Start user session
//Check if the data from the login form was submitted.
// isset() checks if the data exists
if (isset($_POST['username'], $_POST['password'])) {
	if ($stmt = $mysqli->prepare('SELECT `id`, `password`, `activation_code`, `email`, `admin` FROM `accounts` WHERE `username` = ?' )) {
		$stmt->bind_param('s',$_POST['username']);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows() > 0) {
			$stmt->bind_result($id, $hash, $currentCodestate, $email, $admin);
			$stmt->fetch();

			if (password_verify($_POST['password'], $hash)) {
				if($currentCodestate == "Activated") {
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $_POST['username'];
					$_SESSION['id'] = $id;
					$_SESSION['admin'] = $admin;
					
					header('Location: profile.php');
				} else {
					$userResponses[] = 'Account not activated.';
					if ($stmt = $mysqli->prepare('UPDATE `accounts` SET `activation_code` = ? WHERE `username` = ?' )) {
						$activationCode = uniqid();
						$stmt->bind_param('ss', $activationCode, $_POST['username']);
						$stmt->execute();
						
						$activationLink = getMyUrl() . '/activate.php?email=' . $email . '&code=' . $activationCode;
						$userResponses[] = 'Please click the following link to activate your account: <a href="' . $activationLink . '">' . $activationLink . '</a>';
					}
				}
			} else {
				$userResponses[] = 'Incorrect password';
			}
		} else {
			$userResponses[] = 'Incorrect username';
		}
	} else {
		$userResponses[] = 'Could not prepare SQL statement.';
	}
}

if (isset($_SESSION['loggedin'])) {
    header('Location: profile.php');
}

?>

<?= template_header('Login') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<?php if ($userResponses): ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $userResponses);
			// echo '<br>';
			// var_dump($_POST); ?>
</p>
<?php endif; ?>
<h1 class="title">Login</h1>
<form class="block" action="" method="post">
    <div class="field">
        <label class="label">Username</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="username" placeholder="LeeroyJenkins247" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label class="label">Password</label>
        <div class="control has-icons-left">
            <input class="input" type="password" name="password" placeholder="P@55W0RD" required>
            <span class="icon is-left">
                <i class="fas fa-lock"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button class="button is-success">Login</button>
        </div>
    </div>
</form>

<a href="register.php" class="block button is-small">
    <span class="icon">
        <i class="fas fa-user-plus"></i>
    </span>
    <span>Sign Up</span>
</a>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>