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
<form method="post" action="register.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Imię*</label>
        <input type="text" name="imie">
    </div>
    <div class="input-group">
        <label>Nazwisko*</label>
        <input type="text" name="nazwisko">
    </div>
    <div class="input-group">
        <label>Email*</label>
        <input type="email" name="email">
    </div>
    <div class="input-group">
        <label>Numer telefonu</label>
        <input type="number" name="telefon">
    </div>
    <div class="input-group">
        <label>PESEL*</label>
        <input type="text" name="pesel">
    </div>
    <h3>Adres zamieszkania</h3>
    <div class="form-address">
        <div class="input-group form-address-input">
            <label>Miejscowość*</label>
            <input type="text" name="miejscowosc">
        </div>
        <div class="input-group form-address-input">
            <label>Ulica*</label>
            <input type="text" name="ulica">
        </div>
        <div class="input-group form-address-input">
            <label>NR domu*</label>
            <input type="text" name="nr_domu">
        </div>
        <div class="input-group form-address-input">
            <label>NR lokalu</label>
            <input type="text" name="nr_lokalu">
        </div>
    </div>
    <div class="input-group">
        <label>Hasło*</label>
        <input type="password" name="haslo_1">
    </div>
    <div class="input-group">
        <label>Potwierdź hasło*</label>
        <input type="password" name="haslo_2">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="reg_user">Rejestracja</button>
    </div>
    <p>
        Jesteś już członkiem? <a href="login.php">Zaloguj się</a>
    </p>
</form>
</div>
</body>
</html>