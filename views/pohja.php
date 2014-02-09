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

            <?php if (onkoKirjautunut()): ?>
                <div class="navbar-header">
                    <a class="navbar-brand" href="tehtavalista.php">Muistilista</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="uusitehtava.php">Lisää uusi tehtävä</a></li>
                    <li><a href="logout.php">Kirjaudu ulos</a></li>
                </ul>
            <?php else: ?>
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Muistilista</a>
                </div>
            <?php endif; ?>
        </nav>
        <?php if (!empty($_SESSION['ilmoitus'])): ?>
            <?php
            unset($_SESSION['ilmoitus']);
            ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['ilmoitus']; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($data->virheet)): ?>
            <div class="alert alert-danger"><?php echo $data->virheet; ?></div>
        <?php endif; ?>
        <?php require $sivu; ?>
    </body>
</html>