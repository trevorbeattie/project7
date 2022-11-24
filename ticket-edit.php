<?php
require 'config.php';

$pdo = pdo_con();

//additional php code for this page goes here
if (isset($_GET['id'])) {
    $ticket_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM `tickets` WHERE id = ?');
    $stmt->execute([$ticket_id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$ticket) {
        $userResponses[] = "A ticket with that 'id' did not exist.";
    }

    if (!empty($_POST)) {
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $msg = isset($_POST['msg']) ? $_POST['msg'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
    
        $stmt = $pdo->prepare('UPDATE `tickets` SET `title` = ? ,`msg` = ? ,`email` = ? WHERE `id` = ?');
        $stmt->execute([$title, $msg, $email, $_GET['id']]);
        header('Location: tickets.php');
    
        // Output the contact created message
        $userResponses[] = "Contact was updated successfully! Returning to the contacts page.";
    } 
} else {
    $userResponses[] = "Contact was not updated successfully... No record with that ID was found. <a href='contacts.php'>Return to the contacts page?</a>";
}
?>

<?= template_header('Edit Ticket') ?>
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
<h1 class="title">Edit Ticket</h1>
<div class="box">
    <form action="" method="post">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" value="<?=$ticket['title']?>" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left">
                <input class="input" type="text" name="email" value="<?=$ticket['email']?>">
                <span class="icon is-left">
                    <i class="fas fa-at"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Message</label>
            <div class="control">
                <textarea class="textarea" name="msg" required><?php echo $ticket['msg'];?></textarea>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-success">Edit Ticket</button>
            </div>
            <div class="control">
                <a class="button is-warning" href="tickets.php">Cancel</a>
            </div>
        </div>

    </form>
</div>
<?= template_footer() ?>