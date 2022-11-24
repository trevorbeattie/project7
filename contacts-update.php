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

    if (!empty($_POST)) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
    
        $stmt = $pdo->prepare('UPDATE `contacts` SET `name` = ? ,`email` = ? ,`phone` = ? ,`title` = ? WHERE `id` = ?');
        $stmt->execute([$name, $email , $phone, $title, $_GET['id']]);
        header('Location: contacts.php');
    
        // Output the contact created message
        $userResponses[] = "Contact was updated successfully! Returning to the contacts page.";
    } 
} else {
    $userResponses[] = "Contact was not updated successfully... No record with that ID was found. <a href='contacts.php'>Return to the contacts page?</a>";
}
?>

<?= template_header('Contact Update') ?>
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
    <h1 class="title">Update Contact</h1>
    <form action="contacts-update.php?id=<?=$contact['id']?>" method="post">
    <div class="box">
    <div>
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" placeholder="Jenny Call-Keller" value="<?=$contact['name']?>" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" placeholder="jenny@tutone.com" value="<?=$contact['email']?>" required>
            <span class="icon is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Phone</label>
        <div class="control has-icons-left">
            <input class="input" type="tel" name="phone" placeholder="555-867-5309" value="<?=$contact['phone']?>" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" placeholder="One Hit Wonder" value="<?=$contact['title']?>" required>
            <span class="icon is-left">
                <i class="fas fa-user-plus"></i>
            </span>
        </div>
    </div>
    <div>
        <div class="control">
            <button class="button">Update Contact</button>
        </div>
    </div>
    </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>