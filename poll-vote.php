<?php
require 'config.php';

$pdo = pdo_con();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['poll_answer'])) {
            $stmt = $pdo->prepare('UPDATE `poll_answers` SET `votes` = `votes` + 1 WHERE `id` = ?');
            $stmt->execute([$_POST['poll_answer']]);
            header('Location: poll-result.php?id=' . $_GET['id']);
        }
    }
} else {
    $userResponses[] = "Error: No poll with that ID was found. <a href='polls.php'>Return to the polls page?</a>";
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
    <h1 class="title">Poll Vote</h1>
    <div class="box">
    <p class="subtitle"><?=$poll['title']?></p>
    <form action="?id=<?=$_GET['id']?>" method="post">
    <?php foreach($poll_answers as $poll_answer) : ?>
        <div class="field">
            <div class="control">
                    <label class="radio">
                        <input type="radio" name="poll_answer" value="<?=$poll_answer['id']?>" required>
                        <?=$poll_answer['title']?>
                    </label><br>
            </div>
        </div>
        <?php endforeach?>
            <div class="field">
                <div class="control">
                    <button class="button is-success" value="vote" type="submit">Vote</button>
                </div> 
            </div>
    </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>