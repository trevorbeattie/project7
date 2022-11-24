<?php
require 'config.php';

//Additional php code for this page goes here

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
    <h1 class="title">Page Heading</h1>
    <p>This is where page content goes.</p>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>