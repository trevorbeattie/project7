<?php
require 'config.php';

$pdo = pdo_con();

//additional php code for this page goes here
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM `contacts` WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        $userResponses[] = "A contact with that 'id' did not exist.";
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
        $stmt = $pdo->prepare('DELETE FROM `contacts` WHERE `id` = ?');
        $stmt->execute([$_GET['id']]);
        $userResponses[] = "Contact was deleted! <a href='contacts.php'>Return to the contacts page?</a>";
        } else {
            header('Location: contacts.php');
        }
    }
} else {
    $userResponses[] = "Contact was not deleted... No record with that ID was found. <a href='contacts.php'>Return to the contacts page?</a>";
}

?>

<?= template_header('Delete Confirmation') ?>
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
    <div class="box">
    <h1 class="title">Delete Confirmation</h1>
    <p>Are you sure you want to delete this contact: <?=$contact['name'] ?> </p>
    <div class="buttons">
        <a href="?id=<?= $contact['id'] ?>&confirm=yes" class="button is-success">
            Yes
        </a>
        <a href="?id=<?= $contact['id'] ?>&confirm=no" class="button is-danger">
            No
        </a>
    </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>