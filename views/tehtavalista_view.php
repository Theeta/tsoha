<div class="container">
    <h1>Tehtävät</h1>
    <p>Tehtäviä yhteensä <?php echo ($data->lukumaara); ?> kappaletta</p>

    <div class="container">
        <ul class="pagination">
            <?php if ($data->sivu > 1): ?>
                <li><a href="tehtavalista.php?sivu=<?php echo $data->sivu - 1; ?>">&laquo;</a></li>
            <?php else: ?>
                <li class="disabled"><a href="#">&laquo;</a></li>
            <?php endif; ?>
            <?php $numero = 1 ?>
            <?php while ($numero <= $data->sivuja) { ?>
                <?php if ($data->sivu == $numero): ?>
                    <li class="active"><a href="#"><?php echo $numero ?> <span class="sr-only">(current)</span></a></li>
                <?php else: ?>
                    <li><a href="tehtavalista.php?sivu=<?php echo $numero; ?>"><?php echo $numero ?></a></li>
                <?php endif; ?>
                <?php $numero++;
            }
            ?>
            <?php if ($data->sivu < $data->sivuja): ?>
                <li><a href="tehtavalista.php?sivu=<?php echo $data->sivu + 1; ?>">&raquo;</a></li>
            <?php else: ?>
                <li class="disabled"><a href="#">&raquo;</a></li>
<?php endif; ?>
        </ul>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tehtävän kuvaus</th>
                    <th>Tärkeysaste</th>
                    <th>Muokkaa</th>
                    <th>Poista</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($data->tehtavat as $tehtava): ?>
                    <tr>
                        <td><?php echo $tehtava->getKuvaus(); ?></td>
                        <td><?php echo $tehtava->getTarkeysaste(); ?></td>
                        <td><form action="index.php?sivu=<?php echo $tehtava->getId(); ?>" method="link" ><button input type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button></form></td>
                        <td><form action="index.php" method="link" ><button type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button></form></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
