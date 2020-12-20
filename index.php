>
<?php

        session_start(); // подключаем механизм сессий
        if(isset($_GET['logout'])){ // если был переход по ссылке Выход
            unset( $_SESSION['user'] ); // удаляем информацию о пользователе
            header('Location: /'); // переадресация на главную страницу
            exit(); // дальнейшая работа скрипта излишняя
        }
        if (isset($_POST['in'])){
            if( !isset($_SESSION['user']) && isset($_POST['login']) &&
            isset($_POST['password']) && ($f=fopen('users.csv', 'rt'))){
                if( $f ){ // если файл успешно открыт
                    while( !feof($f) ) // пока не найден конец файла
                    {
                    // разбиваем текущую строку файла в массив
                    $test_user = explode(';', fgets($f) );
                    if( trim($test_user[0]) == $_POST['login'] ){ // если найден логин
                        if((isset($test_user[1])) && (trim($test_user[1]) == $_POST['password'])){
                            $_SESSION['user'] = $test_user; // в сессию
                            header('Location: /'); // редирект на главную
                            exit(); // дальнейшая работа скрипта излишняя
                        }
                        else // если пароль не совпал
                            break; // прекращаем итерации
                        }
                    }
                    echo '<div>Неверный логин или пароль!</div>';
                    fclose($f); // закрываем файл
                    }
    }
}

    ?>
    <?php
        if(!isset($_COOKIE['user']))
        echo'
    <h2>Аутентификация</h2>
    <div class="form">
        <form action="" method="post">
        <div class="form__name">
            <label for="name">Логин</label>
            <input type="text" name="login" id="login" placeholder="Введите логин"><br>
        </div>
        <div class="form__name">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Введите пароль"><br>
        </div>
        <div class="form__name_button">
            <input name="in" type="submit" value="Войти" class="form__button">
        </div>
        </form>
    </div>';
        else {echo '<p>Добро пожаловать, '.$_SESSION['user'].'!</p>';
            echo '<a href="/?logout=">Выход</a>';
            include 'tree.php';} ?>
