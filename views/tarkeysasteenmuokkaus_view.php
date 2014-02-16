<div class="container">
    <h1>Tärkeysasteet</h1>

    <div class="container">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tärkeysaste</th>
                    <th>Muokkaa</th>
                    <th>Poista</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->tarkeysasteet as $tarkeysaste): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tarkeysaste->getNimi()); ?></td>
                        <td><a href="tarkeysasteennimenmuokkaus.php?id=<?php echo $tarkeysaste->getId(); ?>"<button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></button> </a></td>
                        <td>
                            <form action="tarkeysasteenpoisto.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $tarkeysaste->getId(); ?>" >
                                <button type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <form role="form" action="uusitarkeysaste.php" method="POST">     
            <td><div class="form-group">
                <input type="text" class="form-control" id="inputNimi" name="nimi" placeholder="Lisää uusi tärkeysaste">
            </div></td>
            <td></td>
            <td><div class="form-group">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div></td>
            </form>
            </tbody>
        </table>
    </div>
</div>
