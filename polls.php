<?php
require 'config.php';
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$_SESSION['active_page'] = $activePage;


$pdo = pdo_con();
//Additional php code for this page goes here
//Prepare SQL statement to get contact records from our DB
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
//Fetch and store the results in a data object
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Polls') ?>
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
    <?php template_admin_nav($activePage); ?>
    <?php else: header('Location: profile.php'); ?>
    <?php endif; ?>
    <div class="column">
        <h1 class="title">Polls</h1>
        <hr />
        <!-- <p class="subtitle">Welcome, here is a list of polls.</p> -->
        <div class="box">
            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Title</td>
                        <td>Answers</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <?php foreach($polls as $poll) : ?>
                <tr>
                    <td><?= $poll['id'] ?></td>
                    <td><?= $poll['title'] ?></td>
                    <td><?= $poll['answers'] ?></td>
                    <td>
                        <a href="poll-vote.php?id=<?=$poll['id']?>" class="button is-success is-small">
                            <i class="fas fa-poll" alt="Create a new poll."></i>
                        </a>
                        <a href="poll-delete.php?id=<?=$poll['id']?>" class="button is-danger is-small">
                            <i class="fas fa-trash" alt="Delete this poll."></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach?>
            </table>
        </div>
        <a href="poll-create.php" class="button is-success"> New Poll</a>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>