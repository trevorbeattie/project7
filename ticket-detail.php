<?php
require 'config.php';

$pdo = pdo_con();

//additional php code for this page goes here
if (isset($_GET['id'])) {
    $ticket_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM `tickets` WHERE id = ?');
    $stmt->execute([$ticket_id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($ticket);
    if (!$ticket) {
        $userResponses[] = "A ticket with that 'id' did not exist.";
    }

    if ($ticket) {
        $stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = ?');
        $stmt->execute([$_GET['id']]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo '<br>';
        // var_dump($comments);
    }
    if (!empty($_POST)) {
        $msg = isset($_POST['msg']) ? $_POST['msg'] : '';
        $created = date("Y-m-d H:i:s"); 
        // 2022-01-01 16:23:39
        $stmt = $pdo->prepare('INSERT INTO `tickets_comments`(`ticket_id`,`msg`,`created`) VALUES (?,?,?)');
        $stmt->execute([$ticket_id, $msg, $created]);
        header("Location: ticket-detail.php?id=" . $ticket_id);
    }
    if (isset($_GET['status'])) {
        $updated_status = $_GET['status'];
        $stmt = $pdo->prepare('SELECT `status` FROM `tickets` WHERE id = ?');
        $stmt->execute([$ticket_id]);
        $current_status = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!($updated_status == $current_status)) {
            $stmt = $pdo->prepare('UPDATE `tickets` SET `status` = ? WHERE `id` = ?');
            $stmt->execute([$updated_status, $ticket_id]);
            header("Location: ticket-detail.php?id=" . $ticket_id);
        }
    }
}
?>


<?= template_header('Ticket Details') ?>
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
<div class="block">
    <h1 class="title">Ticket Detail</h1>
    <h2 class="subtitle"><a href="tickets.php" class="is-info">View all tickets</a></h2>
</div>
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <?= $ticket['title'] ?></p>
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
        <a href="ticket-detail.php?id=<?=$ticket['id']?>&status=closed" class="card-footer-item is-size-4">
            <i class="fas fa-times"></i> Close
        </a>
        <a href="ticket-detail.php?id=<?=$ticket['id']?>&status=resolved" class="card-footer-item is-size-4"><i
                class="fas fa-check"></i> Resolve
        </a>
        <a href="ticket-detail.php?id=<?=$ticket['id']?>&status=open" class="card-footer-item is-size-4">
            <i class="fas fa-clock"></i> Re-Open
        </a>
    </footer>
</div>
<div class="block">
    <form action="" method="post">
        <div class="field">
            <label class="label"></label>
            <div class="control">
                <textarea name="msg" class="textarea" placeholder="Enter your comment here..." required=""></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link">Post Comment</button>
            </div>
        </div>
    </form>
    <hr>
    <div class="content">
        <?php foreach($comments as $comment) : ?>
        <p class="box">
            <span><i class="fa fa-comment"></i>
                <?=$comment['created']?><br>
                <?=$comment['msg']?><br>
        </p>
        <?php endforeach?>
    </div>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>