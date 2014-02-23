<div class="container">
    <h1>Muokkaa käyttäjätietoja</h1>
    <form class="form-horizontal" role="form" action="kayttajanmuokkaus.php" method="POST">
        <div class="form-group">
            <label for="inputNimi" class="col-md-2 control-label">Käyttäjän nimi:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="inputNimi" name="nimi" value="<?php
                if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getNimi());
                endif;
                ?>"/>
            </div>
        </div>

        <div class="form-group">
            <label for="inputTunnus" class="col-md-2 control-label">Käyttäjätunnus (ei voi muokata):</label>
            <div class="col-md-10">
                <input type="text" readonly="readonly" class="form-control" id="inputTunnus" name="tunnus" value="<?php
                       if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getTunnus());
                       endif;
                       ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword1" class="col-md-2 control-label">Salasana:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="inputPassword1" name="salasana1" value="<?php
                       if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getSalasana());
                       endif;
                       ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword2" class="col-md-2 control-label">Salasana uudelleen:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="inputPassword2" name="salasana2" value="<?php
                       if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getSalasana());
                       endif;
                       ?>">
            </div>
        </div>

        <input type="hidden" name="id" value="<?php
                       if (!empty($data->kayttaja)): echo htmlspecialchars($data->kayttaja->getId());
                       endif;
                       ?>">

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>

    <form action="kayttajanpoisto.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $data->kayttaja->getId(); ?>" >
        <button type="submit" class="btn btn-default">Poista käyttäjä
        </button>
    </form>
</div>
