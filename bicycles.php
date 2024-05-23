<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php include('header.php') ?>

<div class="content">
    <h1>Moje rowery</h1>
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
    <?php $bicycle = 0; ?>
        <?php while ($owner = mysqli_fetch_array(
        $all_owners,MYSQLI_ASSOC)):
        if($owner['id_uzytkownik'] == $_SESSION['userid']) :
            $bicycle += 1 ?>
        <h2 style="margin: 20px 0">Rower <?php echo $bicycle; ?></h2>
            <p>Numer ramy: <?php echo getData('rower', 'id_rower', 'numer_seryjny', $owner["id_rower"]); ?></p>
            <div class="form-container">
                <p>Typ: <?php echo get_type($owner['id_rower']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <select name="typ">
                        <option selected="selected" value=""></option>
                        <?php
                        foreach ($all_types as $type) {
                            ?>
                            <option value="<?php echo $type["id_typ"]; ?>">
                                <?php echo $type["nazwa_typu"]; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="btn" name="change_typ<?php echo ($owner['id_posiada']); ?>" value='Potwierdź'>
                    <?php if(isset($_POST['change_typ' . $owner['id_posiada']])) {
                        btn_change('rower', 'id_rower', $owner['id_rower'], 'id_typ', $_POST['typ']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'bicycles.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>
            <div class="form-container">
                <p>Marka: <?php echo get_mark($owner['id_rower']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <select name="marka">
                        <option selected="selected" value=""></option>
                        <?php
                        foreach ($all_marks as $mark) {
                        ?>
                        <option value="<?php echo $mark["id_marka"]; ?>">
                            <?php echo $mark["nazwa_marki"]; ?>
                        </option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="btn" name="change_mark<?php echo ($owner['id_posiada']); ?>" value='Potwierdź'>
                    <?php if(isset($_POST['change_mark' . $owner['id_posiada']])) {
                        btn_change('rower', 'id_rower', $owner['id_rower'], 'id_marka', $_POST['marka']); ?>
                        <script>
                        setTimeout(function(){
                            window.location.href = 'bicycles.php';
                        }, 0);
                        </script>
                   <?php } ?>
                </form>
            </div>
            <div class="form-container">
                <p>Rozmiar koła: <?php echo getData('rower', 'id_rower', 'rozmiar_kola', $owner["id_rower"]); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="rozmiar_kola">
                    </div>
                    <input type="submit" class="btn" name="change_wheel_size<?php echo ($owner['id_posiada']); ?>" value='Potwierdź'>
                    <?php if(isset($_POST['change_wheel_size' . $owner['id_posiada']])) {
                        btn_change('rower', 'id_rower', $owner['id_rower'], 'rozmiar_kola', $_POST['rozmiar_kola']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'bicycles.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>
        <?php endif;endwhile;?>
    <?php if($bicycle == 0) {
        echo "<h2 style='margin-top: 40px'>Nie posiadasz żadnego roweru.</h2>";
    } ?>
</div>
<script src="index.js"></script>
</body>
</html>
