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
                    <li><a href="tarkeysasteenmuokkaus.php">Muokkaa tärkeysasteita</a></li>
                    <li><a href="luokanmuokkaus.php">Muokkaa luokkia</a></li>
                    <li><a href="kayttajanmuokkaus.php?id=<?php echo $_SESSION['kayttaja_id']; ?>">Käyttäjätiedot</a></li>
                    <li><a href="logout.php">Kirjaudu ulos</a></li>
                </ul>
            <?php else: ?>
                <div class="navbar-header">
                    <a class="navbar-brand" href="login.php">Muistilista</a>
                </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="uusikayttaja.php">Uusi käyttäjä</a></li>
            </ul>
            <?php endif; ?>
        </nav>
        <?php if (!empty($_SESSION['ilmoitus'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['ilmoitus']; ?>
            </div>
            <?php
            unset($_SESSION['ilmoitus']);
            ?>
        <?php endif; ?>
        <?php if (isset($data->virheet)): ?>
            <div class="alert alert-danger">
                <?php if (is_array($data->virheet)): ?>
                    <ul>
                        <?php foreach ($data->virheet as $virhe): ?>
                            <li><?php echo $virhe ?></li>
                        <?php endforeach; ?>
                    </ul>

                <?php else: ?>
                    <p><?php echo $data->virheet ?></p>
                <?php endif; ?>

            </div>
        <?php endif; ?>
        <?php require $sivu; ?>
        
    </body>
</html>