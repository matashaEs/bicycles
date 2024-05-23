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
    <h1>Sprawdź rower</h1>
    <form method="post" action="check_bicycle.php">
        <?php include('errors.php'); ?>
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
        <div class="input-group">
            <label>Numer ramy</label>
            <input type="text" name="numer_seryjny" >
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="check_bicycle">Sprawdź</button>
        </div>
    </form>
</div>
</body>
</html>
