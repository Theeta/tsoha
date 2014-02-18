<div class="container">
    <h1>Muokkaa tehtävää</h1>
    <form class="form-horizontal" role="form" action="muokkaatehtavaa.php" method="POST">
        <div class="form-group">
            <label for="inputKuvaus" class="col-md-2 control-label">Tehtävän kuvaus:</label>

            <div class="col-md-10">
                <input type="text" id="inputKuvaus" name="kuvaus" value="<?php echo htmlspecialchars($data->tehtava->getKuvaus()); ?>"/>
            </div>
        </div>

        <div class="form-group">
            <label for="inputTarkeysasteId" class="col-md-2 control-label">Tehtävän tärkeysaste:</label>
            <select name="tarkeysaste_id">
                <?php foreach ($data->tarkeysasteet as $tarkeysaste): ?>
                    <?php if ($tarkeysaste->getId() == $data->tehtava->getTarkeysaste_id()): ?>
                        <option value="<?php echo $tarkeysaste->getId(); ?>" selected><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></option>
                    <?php else: ?>
                        <option value="<?php echo $tarkeysaste->getId(); ?>"><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="inputLuokat" class="col-md-2 control-label">Tehtävän luokat:</label>
            <div class="checkbox col-md-10">
                <?php foreach ($data->luokat as $luokka): ?>
                    <?php if ($data->tehtava->onkoTehtavanLuokka($data->tehtava->getId(), $luokka->getId())): ?>
                        <input type="checkbox" name="luokka[]" value="<?php echo $luokka->getId(); ?>" checked /><?php echo htmlspecialchars($luokka->getNimi()); ?><br />
                    <?php else: ?>
                        <input type="checkbox" name="luokka[]" value="<?php echo $luokka->getId(); ?>" /><?php echo htmlspecialchars($luokka->getNimi()); ?><br />
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $data->tehtava->getId(); ?>">

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>
</div>
