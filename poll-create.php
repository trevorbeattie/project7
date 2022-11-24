<?php
require 'config.php';

$pdo = pdo_con();
//Additional php code for this page goes here
if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';

    $stmt = $pdo->prepare('INSERT INTO `polls`(`title`, `desc`) VALUES (?,?)');
    $stmt->execute([$title, $description]);

    //Get the new Poll ID
    $poll_id = $pdo->lastInsertId();

    foreach ($answers as $answer) {
        $stmt = $pdo->prepare('INSERT INTO `poll_answers`(`poll_id`, `title`) VALUES (?,?)');
        $stmt->execute([$poll_id, $answer]);
    }
    
    $userResponses[] = "Poll was created successfully! <a href='polls.php'>Return to the polls page?</a>";

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
    <h1 class="title">Create Poll</h1>
    <div class="box">
        <form action="" method="post">
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                        <input class="input" type="text" name="title" placeholder="Poll Title" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                        <input class="input" type="text" name="description" placeholder="Poll Description" >
                </div>
            </div>
            <div class="field">
                <label class="label">Answers (one answer per line)</label>
                <div class="control">
                        <textarea class="textarea" name="answers" required></textarea>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button">Create Poll</button>
                </div>
            </div>
        </form>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>