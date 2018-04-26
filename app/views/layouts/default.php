<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/default.css">
</head>
<body class="bg-light">
<?php require_once(ROOT . '/app/views/layouts/header.php'); ?>

<div class="container bg-white">
    <div class="row">
        <div id="wrapper" class="col-md-10">
			<?php echo $content; ?>
        </div>
        <div id="sidebar" class="col-md-2 bg-light">
            <?php require_once (ROOT . '/app/views/layouts/sidebar.php');?>
        </div>
    </div>
</div>
<?php require_once(ROOT . '/app/views/layouts/footer.php'); ?>
</body>
</html>