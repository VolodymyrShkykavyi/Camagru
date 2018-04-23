<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$title; ?></title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/default.css">
</head>
<body>
    <?php require_once (ROOT . '/app/views/layouts/header.php'); ?>
    <div id="wrapper" class="p-3 w-100">
        <?php echo $content; ?>
    </div>
    <?php require_once (ROOT . '/app/views/layouts/footer.php'); ?>
</body>
</html>