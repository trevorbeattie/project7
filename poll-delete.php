<?php
require 'config.php';

$pdo = pdo_con();
//Additional php code for this page goes here


if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM `polls` WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$poll) {
        $userResponses[] = "A poll with that 'id' did not exist.";
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
        $stmt = $pdo->prepare('DELETE FROM `polls` WHERE `id` = ?');
        $stmt->execute([$_GET['id']]);

        $stmt = $pdo->prepare('DELETE FROM `poll_answers` WHERE `poll_id` = ?');
        $stmt->execute([$_GET['id']]);
        $userResponses[] = "Poll was deleted! <a href='polls.php'>Return to the polls page?</a>";
        } else {
            header('Location: polls.php');
        }
    }
} else {
    $userResponses[] = "Poll was not deleted... No poll with that ID was found. <a href='polls.php'>Return to the polls page?</a>";
}
?>

<?= template_header('Delete Poll') ?>
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
    <h1 class="title">Poll Delete</h1>
    <p>Are you sure you want to delete this poll?</p>
    <div class="buttons">
        <a href="?id=<?= $poll['id'] ?>&confirm=yes" class="button is-success">
            Yes
        </a>
        <a href="?id=<?= $poll['id'] ?>&confirm=no" class="button is-danger">
            No
        </a>
    </div>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>