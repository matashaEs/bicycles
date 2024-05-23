<?php include('server.php'); ?>
<?php include('send.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php include('header.php') ?>

<div class="content">
    <h1>Skrzynka</h1>
    <table>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Numer ramy</th>
            <th>Szczegóły zakupu</th>
        </tr>
        <?php while ($owner = mysqli_fetch_array(
            $all_owners,MYSQLI_ASSOC)):
                if($owner['admin'] == 0) :
                    $owners = 1;
                    $email = getData('uzytkownik', 'id_uzytkownik', 'email', $owner['id_uzytkownik']); ?>
                    <tr>
                        <td><?php echo getData('uzytkownik', 'id_uzytkownik', 'imie', $owner['id_uzytkownik']); ?></td>
                        <td><?php echo getData('uzytkownik', 'id_uzytkownik', 'nazwisko', $owner['id_uzytkownik']); ?></td>
                        <td><?php echo getData('rower', 'id_rower', 'numer_seryjny', $owner['id_rower']); ?></td>
                        <td><?php echo $owner['opis']; ?></td>
                        <td>
                            <form method="post" style="padding: 0;">
                                <input type="submit" class="btn" name="add<?php echo ($owner['id_posiada']); ?>" value='Dodać'>
                                <?php if(isset($_POST['add' . $owner['id_posiada']])) {
                                    send_message($email, 'Aktualizacja rowera', 'Nowy rower dodany');
                                    add_owner($owner['id_posiada'], $owner['data_od'], $owner['id_rower'], $owner['id_uzytkownik']);
                                    header("Refresh:0; url=box.php");
                                } ?>
                            </form>
                        </td>
                        <td>
                            <form method="post" style="padding: 0;">
                                <input value='Usunąć' type="submit" class="btn" name="remove<?php echo ($owner['id_posiada']); ?>">
                            </form>
                            <?php if(isset($_POST['remove' . $owner['id_posiada']])) {
                                remove_owner($owner['id_posiada']);
                                send_message($email, 'Aktualizacja rowera', 'Rower nie jest dodany');
                                header("Refresh:0; url=box.php");
                            } ?>
                        </td>
                    </tr>
                <?php endif;endwhile;?>
    </table>

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

