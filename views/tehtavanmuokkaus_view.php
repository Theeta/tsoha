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
        <input type="hidden" name="id" value="<?php echo $data->tehtava->getId(); ?>">

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
    </form>
</div>
