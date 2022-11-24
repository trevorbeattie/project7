<?php
require 'config.php';

$activePage = basename($_SERVER['PHP_SELF'], ".php");

//Prepare SQL statement to get contact records from our DB
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id');
$stmt->execute();
//Fetch and store the results in a data object
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Contacts') ?>
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
<div class="columns">
    <?php if ($_SESSION['admin'] == 1): ?>
    <?php template_admin_nav($activePage) ?>
    <!-- Dont include the below line on the profile page -->
    <?php else: header('Location: profile.php'); ?>
    <?php endif; ?>
    <div class="column">
        <h1 class="title">Contacts</h1>
        <hr />
        <div class="box">
            <table class="table is-bordered is-hoverable is-selected is-fullwidth is-striped is-narrow">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Title</td>
                        <td>Created</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($contacts as $contact) : ?>
                    <tr>
                        <td><?= $contact['id'] ?></td>
                        <td><?= $contact['name'] ?></td>
                        <td><?= $contact['email'] ?></td>
                        <td><?= $contact['phone'] ?></td>
                        <td><?= $contact['title'] ?></td>
                        <td><?= $contact['created'] ?></td>
                        <td>
                            <a href="contacts-update.php?id=<?=$contact['id']?>" class="button is-info is-small">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="contacts-delete.php?id=<?=$contact['id']?>" class="button is-danger is-small">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
        <a href="contacts-create.php" class="button is-success">New Contact</a>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>