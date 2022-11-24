<?php
require 'config.php';

$activePage = basename($_SERVER['PHP_SELF'], ".php");

$pdo = pdo_con();
//Additional php code for this page goes here
//Prepare SQL statement to get ticket records from our DB
$stmt = $pdo->query('SELECT * FROM `tickets`');
//Fetch and store the results in a data object
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($tickets);

$stmt = $mysqli->prepare('SELECT `password`, `email`, `admin` FROM `accounts` WHERE `id` = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($hash, $email, $admin);
$stmt->fetch();
$stmt->close();
?>

<?= template_header('Tickets') ?>
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
<div class="columns">
    <?php if ($_SESSION['admin'] == 1): ?>
    <?php template_admin_nav($activePage); ?>
    <?php else: header('Location: profile.php'); ?>
    <?php endif; ?>
    <div class="column">
        <h1 class="title">Tickets</h1>
        <hr />
        <div class="row columns is-multiline">
            <?php foreach($tickets as $ticket) : ?>
            <div class="column is-4">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <?= $ticket['title'] ?>
                        </p>
                        <?php switch($status = $ticket['status']):
                                case "open":?>
                        <button class="card-header-icon">
                            <span class="icon">
                                <a href="ticket-detail.php?id=<?=$ticket['id']?>" class="button is-info is-medium">
                                    <i class="fas fa-clock"></i>
                                </a>
                            </span>
                        </button>
                        <?php break; ?>
                        <?php case "closed": ?>
                        <button class="card-header-icon">
                            <span class="icon">
                                <a href="ticket-detail.php?id=<?=$ticket['id']?>" class="button is-success is-medium">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        </button>
                        <?php break; ?>
                        <?php case "resolved": ?>
                        <button class="card-header-icon">
                            <span class="icon">
                                <a href="ticket-detail.php?id=<?=$ticket['id']?>" class="button is-success is-medium">
                                    <i class="fas fa-check"></i>
                                </a>
                            </span>
                        </button>
                        <?php break; ?>
                        <?php endswitch; ?>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p><?=$ticket['msg']?></p>
                            <br>
                            <time datetime="<?=$ticket['created']?>"><b>Created:</b> <?=$ticket['created']?></time>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="ticket-detail.php?id=<?=$ticket['id']?>" class="card-footer-item">View</a>
                        <a href="ticket-edit.php?id=<?=$ticket['id']?>" class="card-footer-item">Edit</a>
                        <a href="ticket-delete.php?id=<?=$ticket['id']?>" class="card-footer-item">Delete</a>
                    </footer>
                </div>
            </div>
            <?php endforeach?>
        </div>
        <a href="ticket-create.php" class="button is-success"> New Ticket</a>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>