<div class="container">
    <h1>Luokat</h1>

    <div class="container">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Luokka</th>
                    <th>Muokkaa</th>
                    <th>Poista</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->luokat as $luokka): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($luokka->getNimi()); ?></td>
                        <td><a href="luokannimenmuokkaus.php?id=<?php echo $luokka->getId(); ?>"<button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></button> </a></td>
                        <td>
                            <form action="luokanpoisto.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $luokka->getId(); ?>" >
                                <button type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <form role="form" action="uusiluokka.php" method="POST">     
            <td><div class="form-group">
                <input type="text" class="form-control" id="inputNimi" name="nimi" placeholder="Lisää uusi luokka">
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
