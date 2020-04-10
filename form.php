<<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>
  
  <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>


<div id="container">
<h1> Контракт: </h1>
<div id="for">
<form action="" method="POST">
<h2 id="mt">	ФИО: </h2>
  <input name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>"/ >
  
   <h2> E-mail: </h2> 
  <input name="mail" <?php if ($errors['mail']) {print 'class="error"';} ?> value="<?php print $values['mail']; ?>" /> 
  
  <h2>Год Рождения: </h2>
  <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>">
  	<?php for ($i = 1900; $i<2020; $i++) {?>
  		<option value="<?php print($i);  ?>" <?php if ($i==$values['year']) {print 'selected';}?> > <?php print($i);?> </option>
  	<?php } ?>
  </select>
  
  <h2> Суперспособности: </h2>
  
  <select name="abilities[]" <?php if ($errors['abilities']) {print 'class="error"';} ?> multiple>
  		<option <?php if($ability['first']== "Immortal") {print 'selected';}  ?> value="Immortal"   > Бессмертие </option>
  		<option <?php if($ability['second'] == "Walls") {print 'selected';} ?> value="Walls" > Прохождение сквозь стены </option>
  		<option <?php if($ability['third'] == "Levitation") {print 'selected';} ?> value="Levitation"  > Левитация </option>
  </select>  
  
  <h2>Количество конечностей: </h2><div <?php if ($errors['limps']) {print 'class="error"';} ?>>
  <p>
  	<input name="limps" <?php  if ($values['limps'] == 1) {print 'checked';}?> type=radio value="1" id="r"> 1;
  </p>
   <p>
  	<input name="limps" <?php  if ($values['limps'] == 2) {print 'checked';}?> type=radio value="2" id="r"> 2;
  </p>
   <p>
  	<input name="limps" <?php  if ($values['limps'] == 4) {print 'checked';}?> type=radio value="4" id="r"> 4;
  </p>
  </div>
  
  
  <h2>Пол: </h2>
  <div <?php if ($errors['sex']) {print 'class="error"';} ?>>
  <p>
  	<input name="sex" type=radio value="male" id="r" <?php  if ($values['sex'] == "male") {print 'checked';}?> > Мужской;
  </p>
   <p>
  	<input name="sex" type=radio value="female" id="r" <?php  if ($values['sex'] == "female") {print 'checked';}?> > Женский;
  </p>
  </div>
  
  
  <h2> Биография: </h2>
  <textarea name="bio" <?php if ($errors['bio']) {print 'class="error"';} ?>  ><?php print $values['bio']; ?></textarea>
  
  <h2 > С контрактом ознакомлен:  <input type="checkbox" <?php if ($errors['checkbox']) {print 'class="error"';} ?> name="checkbox" value="T" <?php  if ($values['checkbox'] == "T") {print 'checked';}?> >  </h2> 
  
  <input id="mb" type="submit" value="Отпправить данные" />
</form>
</div>
</div>