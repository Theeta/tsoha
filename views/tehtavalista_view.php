<div class="container">
    <h1>Tehtävät</h1>
    <p>Tehtäviä yhteensä <?php echo ($data->lukumaara); ?> kappaletta</p>
    
    <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Valitse tärkeysaste <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <?php foreach ($data->tarkeysasteet as $tarkeysaste): ?>
                <li><a href="tehtavalista.php?tarkeysaste=<?php echo $tarkeysaste->getId(); ?>"><?php echo $tarkeysaste->getNimi(); ?></a></li>
                <?php endforeach; ?>
                <li class="divider"></li>
                <li><a href="tehtavalista.php">Näytä kaikki tehtävät</a></li>
            </ul>
        </div>

    <div class="container">

        

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
                        <td><?php echo htmlspecialchars($tehtava->getKuvaus()); ?></td>
                        <td><?php echo htmlspecialchars($tehtava->getTarkeysaste()); ?></td>
                        <td><a href="tehtavanmuokkaus.php?id=<?php echo $tehtava->getId(); ?>"<button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span></button> </a></td>
                        <td>
                            <form action="tehtavanpoisto.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $tehtava->getId(); ?>" >
                                <button type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

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
                <?php
                $numero++;
            }
            ?>
            <?php if ($data->sivu < $data->sivuja): ?>
                <li><a href="tehtavalista.php?sivu=<?php echo $data->sivu + 1; ?>">&raquo;</a></li>
            <?php else: ?>
                <li class="disabled"><a href="#">&raquo;</a></li>
                <?php endif; ?>
        </ul>


    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>