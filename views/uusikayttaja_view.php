<div class="container">
    <h1>Uusi käyttäjä</h1>
    <form class="form-horizontal" role="form" action="uusikayttaja.php" method="POST">
        <div class="form-group">
            <label for="inputNimi" class="col-md-2 control-label">Nimi:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="inputKuvaus" name="nimi" value="<?php if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getNimi());
endif; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputTunnus" class="col-md-2 control-label">Käyttäjätunnus:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="inputTunnus" name="tunnus" value="<?php if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getTunnus());
endif; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword1" class="col-md-2 control-label">Salasana:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="inputPassword1" name="salasana1">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword2" class="col-md-2 control-label">Salasana uudelleen:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="inputPassword2" name="salasana2">
            </div>
        </div>

        <input type="hidden" name="lahetetty" value="1">

        <div class="form-group">
            <div class="col-md-2">
                <button type="submit" class="btn btn-default">Luo uusi käyttäjä</button>
            </div>
        </div>
</div>

</form>
</div>
