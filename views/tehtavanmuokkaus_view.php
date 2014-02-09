<div class="container">
    <h1>Uusi tehtävä</h1>
    <form class="form-horizontal" role="form" action="uusitehtava.php" method="POST">
        <div class="form-group">
            <label for="inputKuvaus" class="col-md-2 control-label">Tehtävän kuvaus</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="inputKuvaus" name="kuvaus" value="<?php echo $data->tehtava->getKuvaus() ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputTarkeysasteId" class="col-md-2 control-label">Tehtävän tärkeysaste</label>
            <div class="col-md-10">
                <input type="number" class="form-control" id="inputTarkeysasteId" name="tarkeysaste_id">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>
</div>
