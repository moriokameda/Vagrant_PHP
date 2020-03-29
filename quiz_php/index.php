<?php
require_once(__DIR__ . '/config.php');

$quiz = new MyApp\Quiz();

if (!$quiz->isFinished()) {
    $data = $quiz->getCurrentQuiz();
    shuffle($data['a']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz_PHP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if ($quiz->isFinished()) :?>
        <div id="container">
            <div id="result">
                Your score...
                <div><?= h($quiz->getScore); ?></div>
            </div>
            <a href=""><div id="btn">RePlay?</div></a>
        </div>
        <?php $quiz->reset(); ?>
    <?php else :?>
        <div id="container">
            <h1><?= h($data['q']); ?></h1>
            <ul>
                <?php foreach ($data['a'] as $a) : ?>
                <li class="answer"><?= h($a); ?></li>
                <?php endforeach; ?>
            </ul>
            <div id="btn" class="disabled"><?= $quiz->isLast() ? 'show Result' : 'Next Question';?></div>
            <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
        </div>
    <?php endif; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="quiz.js"></script>
</body>
</html>
