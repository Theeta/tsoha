<div class="container">
    <h1>Muokkaa tärkeysastetta</h1>
    <form class="form-horizontal" role="form" action="tarkeysasteennimenmuokkaus.php" method="POST">
        <div class="form-group">
            <label for="inputNimi" class="col-md-2 control-label">Tärkeysasteen nimi:</label>
            
            <div class="col-md-10">
                <input type="text" id="inputNimi" name="nimi" value="<?php echo htmlspecialchars($data->tarkeysaste->getNimi()) ?>"/>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $data->tarkeysaste->getId() ?>">

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>
</div>
