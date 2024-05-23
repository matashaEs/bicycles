<?php include('server.php') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php include('header.php') ?>

<div class="content">
    <h1>Skradzione rowery</h1>
    <form method='POST' action="stolen_bicycles.php">
        <?php include('errors.php'); ?>
        <div class="select-group">
            <div class="input-group">
                <select name="typ">
                    <option selected="selected" value="all">Wszystkie typy</option>
                    <?php
                    while ($type = mysqli_fetch_array(
                        $all_types,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $type["id_typ"];
                        ?>">
                            <?php echo $type["nazwa_typu"];
                            ?>
                        </option>
                    <?php
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="input-group">
                <select name="marka">
                    <option selected="selected" value="all">Wszystkie marki</option>
                    <?php
                    while ($mark = mysqli_fetch_array(
                        $all_marks,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $mark["id_marka"];
                        ?>">
                            <?php echo $mark["nazwa_marki"];
                            ?>
                        </option>
                    <?php
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="input-group">
                <select name="miejscowosc">
                    <option selected="selected" value="all">Miejscowość</option>
                    <?php
                    while ($city = mysqli_fetch_array(
                        $all_cities,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $city["id_miejscowosc"];
                        ?>">
                            <?php echo $city["miejscowosc"];
                            ?>
                        </option>
                    <?php
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="filter">Filtrować</button>
            </div>
            <div class="input-group">
                <select name="data">
                    <option selected="selected" value="">Data</option>
                    <option value="ASC">Rosnąco</option>
                    <option value="DESC">Malejąco</option>
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="filter">Sortować</button>
            </div>
        </div>
    </form>
    <table>
        <tr>
            <th>Numer ramy</th>
            <th>Typ</th>
            <th>Marka</th>
            <th>Rozmiar koła</th>
            <th>Miejscowość</th>
            <th>Data i czas</th>
            <th>Więcej</th>
        </tr>
        <?php
        while ($bicycle = mysqli_fetch_array(
            $all_bicycles,MYSQLI_ASSOC)):;
            if( $bicycle["skradziony"] == 1 ) : ?>
                <tr>
                    <td><?php echo $bicycle["numer_seryjny"]; ?></td>
                    <td><?php echo getData('typ', 'id_typ', 'nazwa_typu', $bicycle["id_typ"]); ?></td>
                    <td><?php echo getData('marka', 'id_marka', 'nazwa_marki', $bicycle["id_marka"]); ?></td>
                    <td><?php echo $bicycle["rozmiar_kola"]; ?></td>
                    <td><?php echo getData('miejscowosc', 'id_miejscowosc', 'miejscowosc', $bicycle["id_miejscowosc"]); ?></td>
                    <td><?php echo $bicycle["data_kradziezy"]; ?></td>
                    <td><form method="post" style="padding: 0;">
                            <input type="submit" class="btn" name="bicycle_info<?php echo $bicycle['id_rower'] ?>"
                                   value="Pokaż właścicieli"/>
                        </form>
                    </td>
                    <?php

                    if(isset($_POST['bicycle_info' . $bicycle['id_rower']])) {
                        $owners = 0;
                        while ($owner = mysqli_fetch_array(
                                $all_owners,MYSQLI_ASSOC)):
                            if($bicycle["id_rower"] == $owner['id_rower'] && $owner['admin'] == 1) :
                                $owners = 1 ?>
                                <tr style="background: #383838; color: white">
                                    <td style="background: #383838"><?php echo getData('uzytkownik', 'id_uzytkownik', 'imie', $owner['id_uzytkownik']); ?></td>
                                    <td style="background: #383838"><?php echo getData('uzytkownik', 'id_uzytkownik', 'nazwisko', $owner['id_uzytkownik']); ?></td>
                                    <td style="background: #383838"><?php echo $owner['data_od'] ?></td>
                                    <td style="background: #383838"><?php echo $owner['data_do'] ?></td>
                                </tr>
                       <?php endif;
                       endwhile;
                       if($owners == 0) : ?>
                            <tr style="background: #383838; color: white"><td style="background: #383838">Brak info o właścicielach</td></tr>
                        <?php endif; } ?>
                </tr>
        <?php
        endif;
        endwhile;
        ?>
    </table>
</div>

</body>
</html>
