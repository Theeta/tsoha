<div class="container">
    <h1>Uusi tehtävä</h1>
    <form class="form-horizontal" role="form" action="uusitehtava.php" method="POST">
        <div class="form-group">
            <label for="inputKuvaus" class="col-md-2 control-label">Tehtävän kuvaus:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="inputKuvaus" name="kuvaus">
            </div>
        </div>

        <div class="form-group">
            <label for="inputTarkeysasteId" class="col-md-2 control-label">Tehtävän tärkeysaste:</label>
            <select name="tarkeysaste_id">
                <?php foreach ($data->tarkeysasteet as $tarkeysaste): ?>
                    <option value="<?php echo $tarkeysaste->getId(); ?>"><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="inputLuokat" class="col-md-2 control-label">Tehtävän luokat:</label>
            <div class="checkbox col-md-10">
                <?php foreach ($data->luokat as $luokka): ?>
                    <input type="checkbox" name="luokka[]" value="<?php echo $luokka->getId(); ?>" /><?php echo htmlspecialchars($luokka->getNimi()); ?><br />
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
</div>


</form>
</div>
