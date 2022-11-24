<?php
require 'config.php';

$activePage = basename($_SERVER['PHP_SELF'], ".php");
$_SESSION['active_page'] = $activePage;

//Get the user data from the accounts table
if ($_SESSION['loggedin'] == TRUE) {
$stmt = $mysqli->prepare('SELECT `password`, `email`, `admin` FROM `accounts` WHERE `id` = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($hash, $email, $admin);
$stmt->fetch();
$stmt->close();
$_SESSION['admin'] = $admin;
} else {
    header('Location: login.php');
}

// var_dump($_SESSION['admin']);
?>

<?= template_header('Profile') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<?php if ($userResponses): ?>
<p class="notification is-danger is-light">
    <?php echo implode('<br>', $userResponses);
			// echo '<br>';
			// var_dump($_POST); ?>
</p>
<?php endif; ?>
<div class="columns">
    <?php if ($_SESSION['admin'] == 1): ?>
    <?php template_admin_nav($activePage); ?>
    <?php endif; ?>
    <div class="column">
        <h1 class="title">Profile</h1>
        <hr />
        <div class="card">
            <table class="table">
                <tr>
                    <td>Username:</td>
                    <td><?=$_SESSION['name']?></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><?=$hash?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?=$email?></td>
                </tr>
                <?php switch($admin): case 0:?>
                <tr>
                    <td>Roles:</td>
                    <td>None</td>
                </tr>
                <?php break; ?>
                <?php case 1:?>
                <tr>
                    <td>Roles:</td>
                    <td>Admin</td>
                </tr>
                <?php break; ?>
                <?php default: ?>
                <?php endswitch; ?>
            </table>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT -->

<?= template_footer() ?>