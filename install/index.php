<?php
    const config_file_name = "../config.php";

    $config_exist = file_exists(config_file_name);
    $no_action = true;
    $error = false;
    $error_message = "";
    
    if(!$config_exist) {
        if(isset($_GET['action'])) {
            if($_GET['action'] == 'create') {
                $no_action = false;
                //Создание файла конфигурации
                try {
                    $config_file = fopen(config_file_name, "w");
                    fwrite($config_file, "<?php\n\n");

                    fwrite($config_file, "////////////////////\n");
                    fwrite($config_file, "// Конфигурационный файл АИС \"Коммерческие предложения\".\n");
                    fwrite($config_file, "// Автоматически сгенерирован конфигурационной утилитой.\n");
                    fwrite($config_file, "////////////////////\n\n");

                    fwrite($config_file, "unset(\$cfg);\n");
                    fwrite($config_file, "global \$cfg;\n");
                    fwrite($config_file, "\$cfg = new stdClass();\n\n");

                    fwrite($config_file, "\$cfg->dbserver = \"" . $_GET['dbserver'] . "\";\n");
                    fwrite($config_file, "\$cfg->dbname = \"" . $_GET['dbname'] . "\";\n");
                    fwrite($config_file, "\$cfg->dbprefix = \"" . $_GET['dbprefix'] . "\";\n");
                    fwrite($config_file, "\$cfg->dbuser = \"" . $_GET['dbuser'] . "\";\n");
                    fwrite($config_file, "\$cfg->dbpassword = \"" . $_GET['dbpassword'] . "\";\n");

                    fwrite($config_file, "\$cfg->storage_path = \"" . $_GET['storagepath'] . "\";\n\n");

                    fwrite($config_file, "?>\n");
                    fclose($config_file);
                }
                catch(e) {
                    $error = true;
                    $error_message = e;
                }
                //Создание БД
                //$error = true;
                //$error_message = "Создание таблиц БД еще не реализовано";
            }
        }
    }

    if($error) {
        if(file_exists(config_file_name)) {
            try {
                unlink(config_file_name);
            }
            catch(e) {}
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charcet="utf8">
    <link rel="stylesheet" href="install.css">
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="install.js"></script>

    <title>Установка АИС "Коммерческие предложения"</title>
</head>
<body>
<?php
    if($config_exist) {
        printf("<header><div>Первоначальная конфигурация АИС \"Коммерческие предложения\".</div><div>Конфигурация выполнена.</div></header>");
        printf("<div>");
        printf("<div>В целях безопасности настоятельно рекомендуем удалить папку install из корневой директории АИС.</div>");
        printf("<a href=\"/\">Начните работу в системе</a>");
        printf("</div>");
    }
    else {
        if($no_action) {
            //Первый запуск
            printf("<header><div>Первоначальная конфигурация АИС \"Коммерческие предложения\".</div><div>Ввод необходимых данных.</div></header>");
            printf("<form method=\"GET\" action=\"/install\">");
            printf("<input type=\"hidden\" name=\"action\" value=\"create\">");
            
            printf("<fieldset>");
            printf("<legend>Реквизиты базы данных</legend>");

            printf("<label for=\"dbserver\">Адрес сервера БД</label>");
            printf("<input id=\"dbserver\" name=\"dbserver\" type=\"input\" value=\"localhost\"><br>");

            printf("<label for=\"dbname\">Имя БД</label>");
            printf("<input id=\"dbname\" name=\"dbname\" type=\"input\"><br>");

            printf("<label for=\"dbprefix\">Префикс таблиц БД</label>");
            printf("<input id=\"dbprefix\" name=\"dbprefix\" type=\"input\" value=\"off_\"><br>");

            printf("<label for=\"dbuser\">Логин сервера БД</label>");
            printf("<input id=\"dbuser\" name=\"dbuser\" type=\"input\"><br>");

            printf("<label for=\"dbpassword\">Пароль сервера БД</label>");
            printf("<input id=\"dbpassword\" name=\"dbpassword\" type=\"input\"><br>");
            
            printf("</fieldset>");
            
            printf("<fieldset>");
            printf("<legend>Файловое хранилище</legend>");

            printf("<label for=\"storagepath\">Расположение файлового хранилища</label>");
            printf("<input id=\"storagepath\" name=\"storagepath\" type=\"input\"><br>");

            printf("</fieldset>");
            
            printf("<div>");
            printf("<input type=\"submit\" value=\"Сохранить\">");
            printf("<input type=\"reset\" value=\"Отмена\">");
            printf("</div>");

            printf("</form>");
        }
        else {
            if(!$error) {
                printf("<header><div>Первоначальная конфигурация АИС \"Коммерческие предложения\".</div><div>Конфигурация выполнена.</div></header>");
                printf("<div>");
                printf("<div>В целях безопасности настоятельно рекомендуем удалить папку install из корневой директории АИС.</div>");
                printf("<a href=\"/\">Начните работу в системе</a>");
                printf("</div>");
            }
            else {
                printf("<header><div>Первоначальная конфигурация АИС \"Коммерческие предложения\".</div><div>Произошла ошибка.</div></header>");
                printf("<div>");
                printf("<div>Во время установки необходимых параметров произошла ошибка: " . $error_message . "</div>");
                printf("<a href=\"/install\">Вернуться к настройке параметров</a>");
                printf("</div>");
            }
        }
    }
?>
</body>
</html>