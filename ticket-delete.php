<?php
require 'config.php';

$pdo = pdo_con();
//Additional php code for this page goes here


if (isset($_GET['id'])) {
    $ticket_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM `tickets` WHERE id = ?');
    $stmt->execute([$ticket_id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$ticket) {
        $userResponses[] = "A ticket with that 'id' did not exist.";
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
        $stmt = $pdo->prepare('DELETE FROM `tickets` WHERE `id` = ?');
        $stmt->execute([$_GET['id']]);

        $stmt = $pdo->prepare('DELETE FROM `tickets_comments` WHERE `ticket_id` = ?');
        $stmt->execute([$_GET['id']]);
        $userResponses[] = "Ticket was deleted! <a href='tickets.php'>Return to the tickets page?</a>";
        } else {
            header('Location: tickets.php');
        }
    }
} else {
    $userResponses[] = "Ticket was not deleted... No ticket with that ID was found. <a href='tickets.php'>Return to the tickets page?</a>";
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
<div class="box">
    <h1 class="title">Delete Ticket</h1>
    <p>Are you sure you want to delete this ticket?</p>
    <div class="buttons">
        <a href="?id=<?= $ticket['id'] ?>&confirm=yes" class="button is-success">
            Yes
        </a>
        <a href="?id=<?= $ticket['id'] ?>&confirm=no" class="button is-danger">
            No
        </a>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>