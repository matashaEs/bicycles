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
    <h1>Mój profil</h1>
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
    <?php include('errors.php'); ?>
    <?php while ($user = mysqli_fetch_array(
        $all_users,MYSQLI_ASSOC)):
        if($user['id_uzytkownik'] == $_SESSION['userid']) : ?>
            <div class="form-container">
                <p>Imię: <?php echo getData('uzytkownik', 'id_uzytkownik', 'imie', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="imie">
                    </div>
                    <input type="submit" class="btn" name="change_name" value='Potwierdź'>
                    <?php if(isset($_POST['change_name'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'imie', $_POST['imie']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <div class="form-container">
                <p>Nazwisko: <?php echo getData('uzytkownik', 'id_uzytkownik', 'nazwisko', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="nazwisko">
                    </div>
                    <input type="submit" class="btn" name="change_surname" value='Potwierdź'>
                    <?php if(isset($_POST['change_surname'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'nazwisko', $_POST['nazwisko']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <div class="form-container">
                <p>E-mail: <?php echo getData('uzytkownik', 'id_uzytkownik', 'email', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="email" name="email">
                    </div>
                    <input type="submit" class="btn" name="change_email" value='Potwierdź'>
                    <?php if(isset($_POST['change_email'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'email', $_POST['email']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <?php $tel = getData('uzytkownik', 'id_uzytkownik', 'telefon', $user['id_uzytkownik']);
            if(!empty($tel)) : ?>
                <div class="form-container">
                    <p>Numer telefonu: <?php echo $tel; ?></p>
                    <div class="input-group">
                        <button type="button" class="btn btn_add">Zmień</button>
                    </div>
                </div>
                <div class="form-container-hide hidden">
                    <form method="post" style="padding: 0;">
                        <div class="input-group input-group-change">
                            <input type="number" name="telefon">
                        </div>
                        <input type="submit" class="btn" name="change_tel" value='Potwierdź'>
                        <?php if(isset($_POST['change_tel'])) {
                            btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'telefon', $_POST['telefon']); ?>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'profile.php';
                                }, 0);
                            </script>
                        <?php } ?>
                    </form>
                </div>
            <?php else : ?>
                <div class="form-container">
                    <p>Numer telefonu</p>
                    <div class="input-group">
                        <button type="button" class="btn btn_add">Dodaj</button>
                    </div>
                </div>
                <div class="form-container-hide hidden">
                    <form method="post" style="padding: 0;">
                        <div class="input-group input-group-change">
                            <input type="number" name="telefon">
                        </div>
                        <input type="submit" class="btn" name="change_tel" value='Potwierdź'>
                        <?php if(isset($_POST['change_tel'])) {
                            btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'telefon', $_POST['telefon']); ?>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'profile.php';
                                }, 0);
                            </script>
                        <?php } ?>
                    </form>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <p>PESEL: <?php echo getData('uzytkownik', 'id_uzytkownik', 'pesel', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="pesel">
                    </div>
                    <input type="submit" class="btn" name="change_pesel" value='Potwierdź'>
                    <?php if(isset($_POST['change_pesel'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'pesel', $_POST['pesel']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <div class="form-container">
                <p>Miejscowość: <?php echo getData('uzytkownik', 'id_uzytkownik', 'miejscowosc', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="miejscowosc">
                    </div>
                    <input type="submit" class="btn" name="change_city" value='Potwierdź'>
                    <?php if(isset($_POST['change_city'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'miejscowosc', $_POST['miejscowosc']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <div class="form-container">
                <p>Ulica: <?php echo getData('uzytkownik', 'id_uzytkownik', 'ulica', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="ulica">
                    </div>
                    <input type="submit" class="btn" name="change_st" value='Potwierdź'>
                    <?php if(isset($_POST['change_st'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'ulica', $_POST['ulica']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <div class="form-container">
                <p>NR domu: <?php echo getData('uzytkownik', 'id_uzytkownik', 'nr_domu', $user['id_uzytkownik']); ?></p>
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <input type="text" name="nr_domu">
                    </div>
                    <input type="submit" class="btn" name="change_house_number" value='Potwierdź'>
                    <?php if(isset($_POST['change_house_number'])) {
                        btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'nr_domu', $_POST['nr_domu']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>

            <?php $nr_local = getData('uzytkownik', 'id_uzytkownik', 'nr_lokalu', $user['id_uzytkownik']);
            if(!empty($nr_local)) : ?>
                <div class="form-container">
                    <p>Numer lokalu: <?php echo $nr_local; ?></p>
                    <div class="input-group">
                        <button type="button" class="btn btn_add">Zmień</button>
                    </div>
                </div>
                <div class="form-container-hide hidden">
                    <form method="post" style="padding: 0;">
                        <div class="input-group input-group-change">
                            <input type="text" name="nr_lokalu">
                        </div>
                        <input type="submit" class="btn" name="change_nr_local" value='Potwierdź'>
                        <?php if(isset($_POST['change_nr_local'])) {
                            btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'nr_lokalu', $_POST['nr_lokalu']); ?>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'profile.php';
                                }, 0);
                            </script>
                        <?php } ?>
                    </form>
                </div>
            <?php else : ?>
                <div class="form-container">
                    <p>Numer lokalu</p>
                    <div class="input-group">
                        <button type="button" class="btn btn_add">Dodaj</button>
                    </div>
                </div>
                <div class="form-container-hide hidden">
                    <form method="post" style="padding: 0;">
                        <div class="input-group input-group-change">
                            <input type="text" name="nr_lokalu">
                        </div>
                        <input type="submit" class="btn" name="change_nr_local" value='Potwierdź'>
                        <?php if(isset($_POST['change_nr_local'])) {
                            btn_change('uzytkownik', 'id_uzytkownik', $user['id_uzytkownik'], 'nr_lokalu', $_POST['nr_lokalu']); ?>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'profile.php';
                                }, 0);
                            </script>
                        <?php } ?>
                    </form>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <div class="input-group">
                    <button type="button" class="btn btn_add">Zmień hasło</button>
                </div>
            </div>
            <div class="form-container-hide hidden">
                <form method="post" style="padding: 0;">
                    <div class="input-group input-group-change">
                        <label>Aktualne hasło</label>
                        <input type="password" name="haslo_1">
                    </div>
                    <div class="input-group input-group-change">
                        <label>Nowe hasło</label>
                        <input type="password" name="haslo_2">
                    </div>
                    <input type="submit" class="btn" name="change_password" value='Potwierdź'>
                    <?php if(isset($_POST['change_password'])) {
                        btn_change_password($user['id_uzytkownik'], $_POST['haslo_1'],  $_POST['haslo_2']); ?>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'profile.php';
                            }, 0);
                        </script>
                    <?php } ?>
                </form>
            </div>
        <?php endif;endwhile;?>
</div>
<script src="index.js"></script>
</body>
</html>
