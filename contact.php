<?php
require 'config.php';

//additional php code for this page goes here
if (isset($_POST['fullname'], $_POST['email'], $_POST['subject'],$_POST['message'])) {
	// $userResponses[] = "Message was sent...";
	
	$to = 'trevorbeattie@mail.weber.edu';
	$from = 'noreply@weber.edu';
	$subject = $_POST['subject'];
	$message = $_POST['message'];;
	$headers = 'From: '. $from . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();

	if (mail($to, $from, $subject, $message, $headers)) {
		// Success
		$userResponses[] = 'Message sent!';
	}
	
	else {
		// Message failed
		$userResponses[] = 'Message could not be sent! Please check your mail server settings!';
	}

}
?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<?php if ($userResponses): ?>
<p class="notification is-danger is-light">
    <?php
			echo implode('<br>', $userResponses);
			echo '<br>';
			var_dump($_POST); ?>
</p>
<?php endif; ?>

<div class="columns">
    <?php switch($_SESSION['admin']):
			case 1:?>
    <?= template_admin_nav() ?>
    <?php break; ?>
    <?php endswitch; ?>
    <div class="column">
        <form action="" method="post">
            <!-- Add form elements here -->

            <!-- Full Name [COMPLETE] -->
            <div class="field">
                <label class="label">Full Name</label>
                <div class="control">
                    <input name="fullname" class="input" type="text" placeholder="Robert Smith" value required>
                </div>
            </div>

            <!-- Email [COMPLETE] -->
            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input name="email" class="input" type="email" placeholder="rsmith@aol.com" value required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>

            <!-- Subject [COMPLETE] -->
            <div class="field">
                <label class="label">Subject</label>
                <div class="control">
                    <input name="subject" class="input" type="text" placeholder="Enter your subject..." value required>
                </div>
            </div>

            <!-- Message [COMPLETE] -->
            <div class="field">
                <label class="label">Message</label>
                <div class="control">
                    <textarea name="message" class="textarea" placeholder="Type your message here!" value
                        required></textarea>
                </div>
            </div>

            <!-- Send Message -->
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-link" name="send">
                        <span class="icon is-small is-left">
                            <i class="fas fa-paper-plane"></i>

                        </span>
                        <span>
                            Send Message
                        </span>
                    </button>
                </div>
            </div>

    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>