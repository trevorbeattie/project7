<?php
require 'config.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userResponses[] = "<a href='polls.php'>Return to the polls page?</a>";
        $total_votes = 0;
        foreach($poll_answers as $poll_votes) {
            $total_votes += $poll_votes['votes'];
        }
    }}
?>

<?= template_header('Poll Results') ?>
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
    <h1 class="title">Poll Results</h1>
    <div class="box">
    <p class="subtitle">Results of the "<?=$poll['title']?>" poll. </p>
    <?php foreach($poll_answers as $poll_answer) : ?>
            <div class="block">
                    <p class="title is-5"><?=$poll_answer['title']?> (<?=$poll_answer['votes']?> out of <?=$total_votes?>)<br></p>
                    <progress class="progress is-info is-large" value=" <?=$poll_answer['votes']?>" max=<?=$total_votes?>></progress>
            </div>
    <?php endforeach?>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>