<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/default.css">
</head>
<body class="bg-light">
<?php require_once(ROOT . '/app/views/layouts/header.php'); ?>
<?php require_once(ROOT . '/app/views/layouts/mobileMenu.php'); ?>
<div class="container bg-light">
    <div class="row m-0">
        <div id="wrapper" class="col-md-9 col-lg-9 bg-white">
            <?php echo $content; ?>
        </div>
        <div id="sidebar" class="col-md-3 col-lg-3 bg-light pt-3">
            <?php require_once(ROOT . '/app/views/layouts/sidebar.php'); ?>
        </div>
    </div>
</div>
<?php require_once(ROOT . '/app/views/layouts/footer.php'); ?>
</body>
</html>