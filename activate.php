<?php
require 'config.php';

if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $mysqli->prepare('SELECT * FROM `accounts` WHERE `email` = ? AND `activation_code` = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
			if ($stmt = $mysqli->prepare('UPDATE `accounts` SET `activation_code` = ? WHERE `email` = ?')) {
				$newcode = "Activated";
				$stmt->bind_param('ss', $newcode, $_GET['email']);
				$stmt->execute();
				// if ($stmt = $mysqli->prepare('SELECT `*` FROM `accounts` WHERE `email` = ? AND `activation_code` = ?') {
				// 	$stmt->bind_param('ss', $newcode, $_GET['email']);
				// 	$stmt->execute();
				// }
				$userResponses[] = "Your account has been activated";
			}
		}
	}
} else {
	$userResponses[] = "Not all parameters were set. Please try again.";
}
?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

	<!-- START PAGE CONTENT -->
	<?php if ($userResponses): ?>
	<p class="notification is-danger is-light">
		<?php echo implode('<br>', $userResponses);?>
	</p>
	<?php endif; ?>
	<h1 class="title">Thank you for activating your account!</h1>
	<p>Please click the "Log in" button above to access your account.</p>
	<!-- END PAGE CONTENT -->

<?= template_footer() ?>