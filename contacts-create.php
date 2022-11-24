<?php
require 'config.php';

//Additional php code for this page goes here
if (!empty($_POST)) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';

    $stmt = $pdo->prepare('INSERT INTO `contacts`(`name`, `email`, `phone`, `title`) VALUES (?,?,?,?)');
    $stmt->execute([$name, $email , $phone, $title]);

    // Output the contact created message
    $userResponses[] = "Contact was created successfully! <a href='contacts.php'>Return to the contacts page?</a>";
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
    <h1 class="title">Create Contact</h1>
    <form action="" method="post">
    <div>
        <label class="label">Name</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="name" placeholder="Jenny Call-Keller" required>
            <span class="icon is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Email</label>
        <div class="control has-icons-left">
            <input class="input" type="email" name="email" placeholder="jenny@tutone.com" required>
            <span class="icon is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Phone</label>
        <div class="control has-icons-left">
            <input class="input" type="tel" name="phone" placeholder="555-867-5309" required>
            <span class="icon is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div>
        <label class="label">Title</label>
        <div class="control has-icons-left">
            <input class="input" type="text" name="title" placeholder="One Hit Wonder" required>
            <span class="icon is-left">
                <i class="fas fa-user-plus"></i>
            </span>
        </div>
    </div>
    <div>
        <div class="control">
            <button class="button">Create Contact</button>
        </div>
    </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>