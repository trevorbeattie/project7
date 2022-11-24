<?php
require 'config.php';

$pdo = pdo_con();
//Additional php code for this page goes here
if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $msg = isset($_POST['msg']) ? $_POST['msg'] : '';
    $created = date("Y-m-d H:i:s"); 

    $stmt = $pdo->prepare('INSERT INTO `tickets`(`title`, `msg`, `email`, `created`, `status`) VALUES (?,?,?,?,?)');
    $stmt->execute([$title, $msg, $email, $created, 'open']);

    $userResponses[] = "Ticket was created successfully! <a href='tickets.php'>Return to the tickets page?</a>";
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
<h1 class="title">Create Ticket</h1>
<div class="box">
    <form action="" method="post">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" placeholder="Ticket Title" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left">
                <input class="input" type="text" name="email" placeholder="Ticket Description">
                <span class="icon is-left">
                    <i class="fas fa-at"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Message</label>
            <div class="control">
                <textarea class="textarea" name="msg" required></textarea>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-success">Create Ticket</button>
            </div>
            <div class="control">
                <a class="button is-warning" href="tickets.php">Cancel</a>
            </div>
        </div>
    </form>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>