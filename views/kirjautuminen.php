<div class="container">
    <h1>Kirjaudu sisään</h1>
    <form class="form-horizontal" role="form" action="login.php" method="POST">
        <div class="form-group">
            <label for="inputTunnus" class="col-md-2 control-label">Käyttäjätunnus</label>
            <div class="col-md-10">
                <?php if (isset($data->kayttaja)): ?>
                <input type="text" class="form-control" id="inputTunnus" name="username" placeholder="Tunnus" value="<?php echo $data->kayttaja; ?>">
                <?php else: ?>
                <input type="text" class="form-control" id="inputTunnus" name="username" placeholder="Tunnus">
                <?php endif ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword1" class="col-md-2 control-label">Salasana</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Salasana">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Kirjaudu sisään</button>
            </div>
        </div>
    </form>
</div>

