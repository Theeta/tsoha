<div class="container">
    <h1>Uusi tehtävä</h1>
    <?php if (empty($data->tarkeysasteet)): ?>
        <a href="tarkeysasteenmuokkaus.php">Lisää tästä ensin ainakin yksi tärkeysaste</a>
    <?php else: ?>
        <form class="form-horizontal" role="form" action="uusitehtava.php" method="POST">
            <div class="form-group">
                <label for="inputKuvaus" class="col-md-2 control-label">Tehtävän kuvaus:</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="inputKuvaus" name="kuvaus" value="<?php if (!empty($data->tehtava)): echo htmlspecialchars($data->tehtava->getKuvaus());
endif; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="inputTarkeysasteId" class="col-md-2 control-label">Tehtävän tärkeysaste:</label>
                <select name="tarkeysaste_id">
                    <?php foreach ($data->tarkeysasteet as $tarkeysaste): ?>
                    <?php if (!empty($data->tehtava) && $tarkeysaste->getId() == $data->tehtava->getTarkeysaste_id()): ?>
                        <option value="<?php echo $tarkeysaste->getId(); ?>" selected><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></option>
                    <?php else: ?>
                        <option value="<?php echo $tarkeysaste->getId(); ?>"><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>

            </div>

            <?php if (!empty($data->luokat)): ?>
            <div class="form-group">
                <label for="inputLuokat" class="col-md-2 control-label">Tehtävän luokat:</label>
                <div class="checkbox col-md-10">
                    <?php foreach ($data->luokat as $luokka): ?>
                    <?php if (!empty($data->tehtava) && $data->tehtava->onkoTehtavanLuokka($data->tehtava->getId(), $luokka->getId())): ?>
                        <input type="checkbox" name="luokka[]" value="<?php echo $luokka->getId(); ?>" checked /><?php echo htmlspecialchars($luokka->getNimi()); ?><br />
                    <?php else: ?>
                        <input type="checkbox" name="luokka[]" value="<?php echo $luokka->getId(); ?>" /><?php echo htmlspecialchars($luokka->getNimi()); ?><br />
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <input type="hidden" name="lahetetty" value="1">
            
            <div class="form-group">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-default">Tallenna</button>
                </div>
            </div>
    </div>

    </form>
<?php endif; ?>
</div>
