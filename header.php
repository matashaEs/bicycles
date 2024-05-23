<div class="header">
    <div class="header-content">
        <a href="index.php"><h3>Home</h3></a>
        <a href="register_bicycle.php"><h3>Zarejestruj rower</h3></a>
        <a href="report_theft.php"><h3>Zgłoś kradzież</h3></a>
        <a href="stolen_bicycles.php"><h3>Skradzione rowery</h3></a>
        <a href="check_bicycle.php"><h3>Sprawdź rower</h3></a>
    </div>

    <?php  if (isset($_SESSION['username'])) : ?>
        <div class="header-content">
            <?php if ($_SESSION['email'] == 'admin@gmail.com' && $_SESSION['password'] == md5('n')) : ?>
                <a href="box.php"><p>Skrzynka</p></a>
            <?php else: ?>
                <a href="bicycles.php"><p>Moje rowery</p></a>
                <a href="profile.php"><p>Profil</p></a>
            <?php endif; ?>
            <p>Hej <strong><?php echo $_SESSION['username']; ?></strong></p>
            <p> <a href="index.php?logout='1'" style="color: red;">Wyjdź</a> </p>
        </div>
    <?php else: ?>

        <p><a href="login.php">Zaloguj się</a></p>

    <?php endif ?>
</div>