<?php

// ユーザの一覧

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
$app->run();

// $app->me();
// $app->getValues()->users;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <form action="logout.php" method="post" id="logout">
            <?= h($app->me()->email); ?><input type="submit" value="Log out">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <h1>Users <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
        <ul>
          <?php foreach ($app->getValues()->users as $user) : ?>
            <li><?= h($user->email); ?></li>
          <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
