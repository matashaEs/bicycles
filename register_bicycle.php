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
<?php  if (!isset($_SESSION['username'])) : ?>

    <p>
        Aby zarejestrować rower należy się zalogować <a href="login.php">Zaloguj się</a>
    </p>

<?php else: ?>
    <h1>Rejestracja roweru</h1>
<form method="post" action="register_bicycle.php">
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
        <label>Jeśli masz inną markę, napisz ją tutaj</label>
        <input type="text" name="inna_marka">
    </div>
    <div class="input-group">
        <label>Rozmiar koła</label>
        <input type="text" name="rozmiar_kola">
    </div>
    <?php include('info.php'); ?>
    <div class="input-group">
        <button type="submit" class="btn" name="reg_bicycle">Zarejestruj</button>
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
<?php endif ?>
</div>
</body>
</html>