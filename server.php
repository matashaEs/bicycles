<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();
$inform = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'test');

$sql_bicycle = "SELECT * FROM `rower`";
$all_bicycles = mysqli_query($db,$sql_bicycle);

$sql_owner = "SELECT * FROM `posiada`";
$all_owners = mysqli_query($db,$sql_owner);

// Get all the types from category typ
$sql_type = "SELECT * FROM `typ`";
$all_types = mysqli_query($db,$sql_type);

// Get all the marks from category marka
$sql_mark = "SELECT * FROM `marka`";
$all_marks = mysqli_query($db,$sql_mark);

$sql_cities = "SELECT * FROM `miejscowosc`";
$all_cities = mysqli_query($db,$sql_cities);

$sql_user = "SELECT * FROM `uzytkownik`";
$all_users = mysqli_query($db,$sql_user);

function add_owner($id_posiada, $data_do, $id_rower, $id_uzytkownik) {
    global $db;

    $query = "UPDATE posiada SET data_do = '$data_do'
                    WHERE id_rower = '$id_rower' AND admin = 1 
                    order by data_od desc limit 1";
    $query2 = "UPDATE posiada SET admin = 1
                    WHERE id_posiada = '$id_posiada'";

    mysqli_query($db, $query);
    mysqli_query($db, $query2);
};

function remove_owner($id_posiada) {
    global $db;
    $query = "DELETE FROM posiada WHERE id_posiada = '$id_posiada'";
    mysqli_query($db, $query);
}

function get_mark($id_rower) {
    global $db;

    $query = "SELECT marka.nazwa_marki
    FROM rower
    JOIN marka ON rower.id_marka = marka.id_marka
    WHERE rower.id_rower = '$id_rower'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $mark = $row['nazwa_marki'];
    return $mark;
}

function get_type($id_rower) {
    global $db;

    $query = "SELECT typ.nazwa_typu
    FROM rower
    JOIN typ ON rower.id_typ = typ.id_typ
    WHERE rower.id_rower = '$id_rower'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $type = $row['nazwa_typu'];
    return $type;
}

function btn_change($table, $elem_id, $elem_name, $set_elem_id, $get_elem_name) {
    global $db;
    $set_elem_name = mysqli_real_escape_string($db, $get_elem_name);
    $query = "UPDATE $table SET $set_elem_id = '$set_elem_name' 
             WHERE $elem_id = '$elem_name'";
    mysqli_query($db, $query);
    $_SESSION['success'] = "Dane zostały zmienione.";
}

function btn_change_password($user_id, $old_pass, $new_pass) {
    global $db;
    global $errors;
    $query = "SELECT haslo FROM uzytkownik WHERE id_uzytkownik = '$user_id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $user_pass = $row['haslo'];
    $old_pass = md5($old_pass);
    if (empty($new_pass)) {
        $_SESSION['success'] = "Pole jest puste";
    } else {
        $new_pass = md5($new_pass);
        if ($new_pass == $old_pass) {
            $_SESSION['success'] = "Aktualne i nowe hasło są takie same";
        } elseif ($user_pass == $old_pass) {
            $query = "UPDATE uzytkownik SET haslo = '$new_pass' 
             WHERE id_uzytkownik = '$user_id'";
            mysqli_query($db, $query);
            $_SESSION['success'] = "Dane zostały zmienione.";
        } else {
            $_SESSION['success'] = "Aktualne hasło nie zgadza sie";
        }
    }
}

function getData($table, $elem_id, $elem_name, $elem_data) {
    global $db;
    $query = "SELECT * FROM $table WHERE $elem_id = '$elem_data'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $id = $row[$elem_name];
    return $id;
}

// FILTER
if (isset($_POST['filter'])) {
    $id_type = mysqli_real_escape_string($db,$_POST['typ']);
    $id_mark = mysqli_real_escape_string($db,$_POST['marka']);
    $id_city = mysqli_real_escape_string($db,$_POST['miejscowosc']);
    $date = mysqli_real_escape_string($db,$_POST['data']);

    if(!empty($id_city)) {
        if(!empty($date)) {
            $query = "SELECT * FROM rower WHERE (id_typ = '$id_type' OR '$id_type' = 'all')
                    AND (id_marka = '$id_mark' OR '$id_mark' = 'all')
                    AND (id_miejscowosc = '$id_city' OR '$id_city' = 'all')
                    ORDER BY data_kradziezy $date";
        } else {
            $query = "SELECT * FROM rower WHERE (id_typ = '$id_type' OR '$id_type' = 'all')
                    AND (id_marka = '$id_mark' OR '$id_mark' = 'all')
                    AND (id_miejscowosc = '$id_city' OR '$id_city' = 'all')";
        }
    } else {
        $query = "SELECT * FROM rower WHERE (id_typ = '$id_type' OR '$id_type' = 'all')
                    AND (id_marka = '$id_mark' OR '$id_mark' = 'all')
                    ";
    }

    $result = mysqli_query($db, $query);
    $all_bicycles = $result;
}

// CHECK BICYCLE
if (isset($_POST['check_bicycle'])) {
    $numer_seryjny = mysqli_real_escape_string($db, $_POST['numer_seryjny']);

    $query = "SELECT skradziony FROM rower WHERE numer_seryjny = '$numer_seryjny'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    $skradziony = $row['skradziony'];

    if (empty($numer_seryjny)) { array_push($errors, "Numer seryjny jest wymagane"); }
    elseif($skradziony == 1) {
        array_push($errors, 'Rower jest skradziony. Proszę o przesłanie informacji o rowerze na adres example@gmail.com.');
    } else {
        $_SESSION['success'] = "Rower nie jest skradziony";
    }
}

// REGISTER THEFT
if (isset($_POST['reg_theft'])) {

    $numer_seryjny = mysqli_real_escape_string($db, $_POST['numer_seryjny']);
    $id_type = mysqli_real_escape_string($db,$_POST['typ']);
    $id_mark = mysqli_real_escape_string($db,$_POST['marka']);
    $id_miejscowosc = mysqli_real_escape_string($db,$_POST['miejscowosc']);

    $bicycle_check_query = "SELECT * FROM rower WHERE numer_seryjny='$numer_seryjny' LIMIT 1";
    $result = mysqli_query($db, $bicycle_check_query);
    $bicycle = mysqli_fetch_assoc($result);

    if (empty($id_miejscowosc)) { array_push($errors, "Miejscowość jest wymagana"); }
    if (empty($numer_seryjny)) { array_push($errors, "Numer seryjny jest wymagane"); }

    if ($bicycle) { // if bicycle exists
        if ($bicycle['numer_seryjny'] === $numer_seryjny) {
            if (count($errors) == 0) {
                $select_query = "SELECT id_rower, skradziony FROM rower WHERE numer_seryjny = '$numer_seryjny'";
                $result = mysqli_query($db, $select_query);
                $row = mysqli_fetch_assoc($result);
                $rower_id = $row['id_rower'];
                $rower_theft = $row['skradziony'];

                if( $rower_theft == 1 ) {
                    $_SESSION['success'] = "Rower już został zarejestrowany wcześniej";
                } else {
                    $query = "UPDATE rower SET skradziony = 1, id_miejscowosc = '$id_miejscowosc', data_kradziezy = current_timestamp()
                    WHERE numer_seryjny = '$numer_seryjny'";
                    mysqli_query($db, $query);

                    $query2 = "UPDATE posiada SET data_do = current_timestamp()
                    WHERE id_rower = '$rower_id'";
                    mysqli_query($db, $query2);

                    $_SESSION['success'] =  "Rower zarejestrowany";
                }
            }
        }
    } else {
        if (empty($id_type)) { array_push($errors, "Typ roweru jest wymagany"); }
        if (empty($id_mark)) { array_push($errors, "Marka roweru jest wymagana"); }

        if (count($errors) == 0) {

            $query = "INSERT INTO rower (numer_seryjny, skradziony, id_typ, id_marka, id_miejscowosc, data_kradziezy)
                          VALUES('$numer_seryjny', 1, '$id_type', '$id_mark','$id_miejscowosc', current_timestamp())";
            mysqli_query($db, $query);
            $_SESSION['success'] = "Rower zarejestrowany";
        }
    }
}

// REGISTER BICYCLE
if (isset($_POST['reg_bicycle'])) {

    $numer_seryjny = mysqli_real_escape_string($db, $_POST['numer_seryjny']);
    $id_type = mysqli_real_escape_string($db,$_POST['typ']);
    $id_mark = mysqli_real_escape_string($db,$_POST['marka']);
    $another_mark = mysqli_real_escape_string($db,$_POST['inna_marka']);
    $info = mysqli_real_escape_string($db, $_POST['info']);
    $wheel_size = mysqli_real_escape_string($db, $_POST['rozmiar_kola']);
    $id_uzytkownik = $_SESSION['userid'];
    $admin = 1;

    $bicycle_check_query = "SELECT * FROM rower WHERE numer_seryjny='$numer_seryjny' LIMIT 1";
    $result = mysqli_query($db, $bicycle_check_query);
    $bicycle = mysqli_fetch_assoc($result);

    if ($bicycle) { // if bicycle exists
        if( $bicycle['skradziony'] == 1) {
            array_push($errors, "Chcesz zarejestrować skradziony rower. Proszę o przesłanie informacji o rowerze na adres example@gmail.com.");
        } elseif ($bicycle['numer_seryjny'] === $numer_seryjny && empty($info)) {
            array_push($errors, 'Rower o tym numerze seryjnym już istnieje. Jeżeli jesteś nowym właścicielem, prosimy o podanie szczegółów zakupu.');
            array_push($inform, 'info');
        } elseif ($bicycle['numer_seryjny'] === $numer_seryjny && !empty($info)) {
        $admin = 0;
        $id_rower = $bicycle['id_rower'];
        $query2 = "INSERT INTO posiada (id_uzytkownik, id_rower, opis, admin)
                        VALUES('$id_uzytkownik', '$id_rower', '$info', '$admin')";
        $result2 = mysqli_query($db, $query2);

        $_SESSION['success'] = "Rower zarejestrowany";
        }
    } else {
        $mark_check_query = "SELECT nazwa_marki FROM marka WHERE nazwa_marki = '$another_mark'";
        $result2 = mysqli_query($db, $mark_check_query);
        $mark = mysqli_fetch_assoc($result2);

        if (empty($numer_seryjny)) {
            array_push($errors, "Numer seryjny jest wymagane");
        }
        if (empty($id_type)) {
            array_push($errors, "Typ roweru jest wymagany");
        }
        if (empty($wheel_size)) {
            array_push($errors, "Rozmiar koła jest wymagany");
        }
        if (empty($id_mark) && empty($another_mark)) {
            array_push($errors, "Marka roweru jest wymagana");
        }
        if($mark['nazwa_marki'] > 0) {
            array_push($errors, $mark );
        }

        if (count($errors) == 0) {

            if(!empty($another_mark)) {
                $query = "INSERT INTO marka (nazwa_marki)
                      VALUES('$another_mark')";
                $result = mysqli_query($db, $query);
                $id_mark = mysqli_insert_id($db);
            }

            $query2 = "INSERT INTO rower (numer_seryjny, id_typ, id_marka, rozmiar_kola)
                      VALUES('$numer_seryjny', '$id_type', '$id_mark', '$wheel_size')";
            $result2 = mysqli_query($db, $query2);

            $id_rower = mysqli_insert_id($db);
            $query3 = "INSERT INTO posiada (id_uzytkownik, id_rower, admin)
                    VALUES('$id_uzytkownik', '$id_rower', '$admin')";
            $result3 = mysqli_query($db, $query3);

            $_SESSION['success'] = 'Rower zarejestrowany';
        }
    }
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $imie = mysqli_real_escape_string($db, $_POST['imie']);
    $nazwisko = mysqli_real_escape_string($db, $_POST['nazwisko']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $haslo_1 = mysqli_real_escape_string($db, $_POST['haslo_1']);
    $haslo_2 = mysqli_real_escape_string($db, $_POST['haslo_2']);
    $pesel = mysqli_real_escape_string($db, $_POST['pesel']);
    $telefon = mysqli_real_escape_string($db, $_POST['telefon']);
    $miejscowosc = mysqli_real_escape_string($db, $_POST['miejscowosc']);
    $ulica = mysqli_real_escape_string($db, $_POST['ulica']);
    $nr_domu = mysqli_real_escape_string($db, $_POST['nr_domu']);
    $nr_lokalu = mysqli_real_escape_string($db, $_POST['nr_lokalu']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($imie)) { array_push($errors, "Imię jest wymagane"); }
    if (empty($nazwisko)) { array_push($errors, "Nazwisko jest wymagane"); }
    if (empty($email)) { array_push($errors, "Email jest wymagany"); }
    if (empty($haslo_1)) { array_push($errors, "Hasło jest wymagane"); }
    if ($haslo_1 != $haslo_2) { array_push($errors, "Te dwa hasła nie pasują do siebie"); }
    if (empty($pesel)) { array_push($errors, "PESEL jest wymagany"); }
    if (empty($miejscowosc)) { array_push($errors, "Mielscowość jest wymagana"); }
    if (empty($ulica)) { array_push($errors, "Ulica jest wymagana"); }
    if (empty($nr_domu)) { array_push($errors, "NR domu jest wymagany"); }
    if (!empty($telefon)) {
        $telefon = "'" . mysqli_real_escape_string($db, $telefon) . "'";
    } else {
        $telefon = "NULL";
    }
    if (!empty($nr_lokalu)) {
        $nr_lokalu = "'" . mysqli_real_escape_string($db, $nr_lokalu) . "'";
    } else {
        $nr_lokalu = "NULL";
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM uzytkownik WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email już istnieje");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $haslo = md5($haslo_1);//encrypt the password before saving in the database

        $query = "INSERT INTO uzytkownik (nazwisko, imie, email, haslo, pesel, telefon, miejscowosc, ulica, nr_domu, nr_lokalu)
                          VALUES('$nazwisko','$imie', '$email', '$haslo', '$pesel', $telefon, '$miejscowosc', '$ulica', '$nr_domu', $nr_lokalu)";
        mysqli_query($db, $query);

        $id_uzytkownik = mysqli_insert_id($db);
        $_SESSION['username'] = $imie;
        $_SESSION['userid'] = $id_uzytkownik;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $haslo;
        header('location: index.php');
    }
}

if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $haslo = mysqli_real_escape_string($db, $_POST['haslo']);

    if (empty($email)) {
        array_push($errors, "Email jest wymagany");
    }
    if (empty($haslo)) {
        array_push($errors, "Hasło jest wymagany");
    }

    if (count($errors) == 0) {
        $haslo = md5($haslo);
        $query = "SELECT * FROM uzytkownik WHERE email='$email' AND haslo='$haslo'";
        $results = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($results);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $user['imie'];
            $_SESSION['userid'] = $user['id_uzytkownik'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['haslo'];
            header('location: index.php');
        }else {
            array_push($errors, "Nieprawidłowy adres e-mail lub hasło");
        }
    }
}

?>