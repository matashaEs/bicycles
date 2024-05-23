<?php include('server.php') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Rowery</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include('header.php') ?>

<div class="content">
    <h1>Zgłoś kradzież roweru</h1>
        <form method="post" action="report_theft.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Numer seryjny ramy</label>
                <input type="text" name="numer_seryjny">
            </div>
            <div class="input-group">
                <label>Wybierz typ roweru</label>
                <select name="typ">
                    <option selected="selected" value=""></option>
                    <?php
                    // use a while loop to fetch data
                    // from the $all_categories variable
                    // and individually display as an option
                    while ($type = mysqli_fetch_array(
                        $all_types,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $type["id_typ"];
                        // The value we usually set is the primary key
                        ?>">
                            <?php echo $type["nazwa_typu"];
                            // To show the category name to the user
                            ?>
                        </option>
                    <?php
                    endwhile;
                    // While loop must be terminated
                    ?>
                </select>
            </div>
            <div class="input-group">
                <label>Wybierz markę roweru</label>
                <select name="marka">
                    <option selected="selected" value=""></option>
                    <?php

                    while ($mark = mysqli_fetch_array(
                        $all_marks,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $mark["id_marka"];
                        // The value we usually set is the primary key
                        ?>">
                            <?php echo $mark["nazwa_marki"];
                            // To show the category name to the user
                            ?>
                        </option>
                    <?php
                    endwhile;
                    // While loop must be terminated
                    ?>
                </select>
            </div>
            <div class="input-group">
                <label>Miejsce, w którym skradziono rower</label>
                <select name="miejscowosc">
                    <option selected="selected" value=""></option>
                    <?php

                    while ($city = mysqli_fetch_array(
                        $all_cities,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $city["id_miejscowosc"];
                        // The value we usually set is the primary key
                        ?>">
                            <?php echo $city["miejscowosc"];
                            // To show the category name to the user
                            ?>
                        </option>
                    <?php
                    endwhile;
                    // While loop must be terminated
                    ?>
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_theft">Zgłoś</button>
            </div>

        </form>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success" >
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>
</div>
</body>
</html>