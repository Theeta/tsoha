<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <title>Muistilista</title>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Muistilista</a>
            </div>
            <?php if (onkoKirjautunut()): ?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Kirjaudu ulos</a></li>
            </ul>
            <?php endif; ?>
        </nav>
        <?php if (!empty($data->virhe)): ?>
            <div class="alert alert-danger"><?php echo $data->virhe; ?></div>
        <?php endif; ?>
        <?php require $sivu; ?>
    </body>
</html>