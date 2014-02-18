<div class="container">
    <h1>Muokkaa luokkaa</h1>
    <form class="form-horizontal" role="form" action="luokannimenmuokkaus.php" method="POST">
        <div class="form-group">
            <label for="inputNimi" class="col-md-2 control-label">Luokan nimi:</label>
            
            <div class="col-md-10">
                <input type="text" id="inputNimi" name="nimi" value="<?php echo htmlspecialchars($data->luokka->getNimi()) ?>"/>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $data->luokka->getId() ?>">

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>
</div>
