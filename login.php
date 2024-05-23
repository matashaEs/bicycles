<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rower</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include('header.php') ?>
<div class="content">
<form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="email" >
    </div>
    <div class="input-group">
        <label>Hasło</label>
        <input type="password" name="haslo">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="login_user">Login</button>
    </div>
    <p>
        Jeszcze nie jesteś członkiem? <a href="register.php">Rejestracja</a>
    </p>
</form>
</div>
</body>
</html>