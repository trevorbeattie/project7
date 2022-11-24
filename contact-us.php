<?php
require 'config.php';

//Additional php code for this page goes here

?>

<?= template_header('Contact Us') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<?php if ($userResponses): ?>
<p class="notification is-danger is-light">
    <?php
			echo implode('<br>', $userResponses);
			// echo '<br>';
			// var_dump($_POST); ?>
</p>
<?php endif; ?>
<div class="block">
    <h1 class="title">Contact Us</h1>
    <hr />
    <p>Want to contact us? Please fill out the information below. (This page totally does nothing right now...)</p>
</div>

<div class="block">
    <form action="" method="post">
        <div class="box">
            <div class="field">
                <label class="label">Subject</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Message Subject" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" name="email" placeholder="user@contact.com">
                    <span class="icon is-left">
                        <i class="fas fa-at"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                <label class="label">Message</label>
                <div class="control">
                    <textarea class="textarea" name="msg" placeholder="What are you contacting us about?" required></textarea>
                </div>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-success">Send Message</button>
            </div>
        </div>
    </form>
</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>