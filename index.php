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
    
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

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
  
  if ($errors['limps']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('limps_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Не выбрано количество конечностей...</div>';
  }
  
  if ($errors['sex']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('sex_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Не выбран пол...</div>';
  }
  
  if ($errors['bio']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('bio_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Не расписана биография...</div>';
  }
  
  if ($errors['checkbox']) {
      // Удаляем куку, указывая время устаревания в прошлом.
      setcookie('checkbox_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Не проставлен чекбокс...</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];
  $values['limps'] = empty($_COOKIE['limps_value']) ? '' : $_COOKIE['limps_value'];
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
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['mail'])) {
    setcookie('mail_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['abilities'])) {
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('abilities_value', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['limps'])) {
    setcookie('limps_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limps_value', $_POST['limps'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['sex'])) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
}


if (empty($_POST['checkbox'])) {
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
}

else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
}


$abilities=serialize($_POST['abilities']);

//$abilities = serialize($_POST['abilities']);

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
}
else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
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

// Сохраняем куку с признаком успешного сохранения.
setcookie('save', '1');

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
}