<?PHP
 
function show_form()
{
?>
<form action="" method=post>
<div align="center">
              <br />Ваше імя*<br />
              <input type="text" name="name" size="40">
              <br />Контактний телефон<br />
              <input type="text" name="tel" size="40">
              <br />Ваш email*<br />
              <input type="text" name="email" size="40">
              <br />Teма<br />
              <input type="text" name="title" size="40">
              <br />Повідомлення*<br />
              <textarea rows="10" name="mess" cols="30"></textarea>
              <br /><input type="submit" value="Відіслати" name="submit">
</div>
</form>
* Відмічені поля, які необхідно заповнити
<?
} 
 
function complete_mail() {
        // $_POST['title'] містить дані з поля "Тема", trim() - забираємо всі лишні пробіли і переноси рядків, htmlspecialchars() - переобразує спеціальні символи в HTML по суті, для того, щоб самі прості спроби взламати сайт не вийшли, ну і  substr($_POST['title'], 0, 1000) - зменшуємо текст до 1000 символів. Для змінних $_POST['mess'], $_POST['name'], $_POST['tel'], $_POST['email'] все аналогічно
        $_POST['title'] =  substr(htmlspecialchars(trim($_POST['title'])), 0, 1000);
        $_POST['mess'] =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000);
        $_POST['name'] =  substr(htmlspecialchars(trim($_POST['name'])), 0, 30);
        $_POST['tel'] =  substr(htmlspecialchars(trim($_POST['tel'])), 0, 30);
        $_POST['email'] =  substr(htmlspecialchars(trim($_POST['email'])), 0, 50);
        // якщо не заповнене поле "Імя" - показуемо помилку 0
        if (empty($_POST['name']))
             output_err(0);
        // якщо не правильно заповнене поле email - показуемо помилку 1
        if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email']))
             output_err(1);
        // якщо не заповнено поле "Повідомлення" - показуемо помилку 2
        if(empty($_POST['mess']))
             output_err(2);
        // створюємо наше повідомлення
        $mess = '
Імя відправника:'.$_POST['name'].'
Контактний телефон:'.$_POST['tel'].'
Контактний email:'.$_POST['email'].'
'.$_POST['mess'];
        // $to - кому відправляємо
        $to = 'test@test.ua';
        // $from - від кого
        $from='test@test.ua';
        mail($to, $_POST['title'], $mess, "From:".$from);
        echo 'Дякую! Ваш лист відісланий.';
} 
 
function output_err($num)
{
    $err[0] = 'ПОМИЛКА! Не введено імя.';
    $err[1] = 'ПОМИЛКА! Невірно введений e-mail.';
    $err[2] = 'ПОМИЛКА! Не введено повідомлення.';
    echo '<p>'.$err[$num].'</p>';
    show_form();
    exit();
} 
 
if (!empty($_POST['submit'])) complete_mail();
else show_form();
 ?>