<?php
/**
 * Интернет-программирование. Задача 8.
 * Реализовать скрипт на веб-сервере на PHP или другом языке,
 * сохраняющий в XML-файл заполненную форму задания 7. При
 * отправке формы на сервере создается новый файл с уникальным именем.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

     // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['mail'] = !empty($_COOKIE['mail_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['limps'] = !empty($_COOKIE['limps_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Не заполнено имя...</div>';
  }

  if ($errors['mail']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('mail_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Не заполнен почтовый адрес...</div>';
  }

  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Не указана дата...</div>';
  }

  if ($errors['abilities']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('abilities_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Не выбраны суперспособности...</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
else{
$errors = FALSE;
if (empty($_POST['fio'])) {
    print('Вы забыли написать свое имя.<br/>');
    $errors = TRUE;
}

if (empty($_POST['mail'])) {
    print('Вы не заполнили поле e-mail. Пожалуйсте, сделайте это.<br/>');
    $errors = TRUE;
}

if (empty($_POST['year'])) {
    print('Заполните год рождения!<br/>');
    $errors = TRUE;
}

if (empty($_POST['abilities'])) {
    print('Вы позабыли выбрать свою способность!<br/>');
    $errors = TRUE;
}

if (empty($_POST['limps'])) {
    print('Количество конечностей вами не указано...<br/>');
    $errors = TRUE;
}

if (empty($_POST['sex'])) {
    print('Выбор пола не был сделан.<br/>');
    $errors = TRUE;
}

if (empty($_POST['bio'])) {
    print('Биография не расписана((<br/>');
    $errors = TRUE;
}

if (empty($_POST['checkbox'])) {
    print('Галочка напротив поля "Ознакомлен с контрактом" не поставлена((<br/>');
    $errors = TRUE;
}

$abilities=serialize($_POST['abilities']);

//$abilities = serialize($_POST['abilities']);

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
    // При наличии ошибок завершаем работу скрипта.
    exit();
}

// Сохранение в базу данных.

$user = 'u16350';
$pass = '1871497';
$db = new PDO('mysql:host=localhost;dbname=u16350', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

// Подготовленный запрос. Не именованные метки.
try {
    $stmt = $db->prepare("INSERT INTO application SET name = ?, mail = ?, year = ?, abilities = ?, limps = ?, sex = ?, bio = ?, checked = ?");
    $stmt -> execute(array($_POST['fio'], $_POST['mail'], $_POST['year'], $abilities, $_POST['limps'], $_POST['sex'], $_POST['bio'],  $_POST['checkbox']));
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}

//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(array('label'=>'perfect', 'color'=>'green'));

//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
 $stmt->bindParam(':firstname', $firstname);
 $stmt->bindParam(':lastname', $lastname);
 $stmt->bindParam(':email', $email);
 $firstname = "John";
 $lastname = "Smith";
 $email = "john@test.com";
 $stmt->execute();
 */

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
}