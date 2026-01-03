<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'версия',
     'title' => 'Установщик Laravel',
     'next' => 'Следующий шаг',
     'back' => 'Предыдущий',
     'finish' => 'Установить',
     'forms' => [
         'errorTitle' => 'Произошли следующие ошибки:',
     ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Добро пожаловать',
        'title' => 'Установщик Laravel',
        'message' => 'Мастер простой установки и настройки.',
        'next' => 'Проверить требования',
        'choose_language' => 'Выберите язык',
        'verify_requirements' => 'Проверить требования',
        'setup_environment' => 'Настройка среды',
        'configure_site' => 'Настроить сайт',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Шаг 1 | Требования к серверу',
        'title' => 'Требования к серверу и разрешения',
        'next' => 'Далее',
        'prev' => 'предыдущий',
        'required' => 'требуется',
        'error' => 'Пожалуйста, проверьте требования к серверу и предоставьте разрешения.'
     ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Шаг 2 | Разрешения',
        'title' => 'Разрешения',
        'next' => 'Настроить среду',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Настройка параметров среды',
            'title' => 'Настройка параметров среды',
            'wizard-button' => 'Настройка мастера форм',
            'classic-button' => 'Классический текстовый редактор',
        ],
        'wizard' => [
            'templateTitle' => 'Шаг 3 | Настройки среды | Управляемый мастер',
            'step3_title' => 'Настройка параметров среды',
            'step4_title' => 'Настройка параметров базы данных',
            'step5_title' => 'Настройка параметров приложения',
            'step6_title' => 'Настройка параметров администратора',
            'step7_title' => 'Успех',
            'step3_description' => 'Пожалуйста, выберите, как вы хотите настроить файл приложений <code>.env</code>.',
            'step4_description' => 'Ниже вы должны ввести данные для подключения к базе данных. Если вы не уверены в этом, обратитесь к своему хосту.',
            'step5_description' => 'Пожалуйста, выберите, как вы хотите настроить файл приложения <code>.env</code>.',
            'step6_description' => 'Ниже вы должны ввести данные об администраторе.',
            'step7_description' => 'W3cms установлен. Спасибо, и наслаждайтесь',
            'tabs' => [
                'environment' => 'Окружающая среда',
                'database' => 'База данных',
                'application' => 'Приложение',
            ],
            'form' => [
                'name_required' => 'Требуется имя среды.',
                'app_name_label' => 'Имя приложения',
                'app_name_placeholder' => 'Имя приложения',
                'app_environment_label' => 'Среда приложения',
                'app_environment_label_local' => 'Локальный',
                'app_environment_label_development' => 'Разработка',
                'app_environment_label_qa' => 'Качество',
                'app_environment_label_production' => 'Производство',
                'app_environment_label_other' => 'Другое',
                'app_environment_placeholder_other' => 'Введите вашу среду...',
                'app_debug_label' => 'Отладка приложения',
                'app_debug_label_true' => 'Истина',
                'app_debug_label_false' => 'Ложь',
                'app_log_level_label' => 'Уровень журнала приложения',
                'app_log_level_label_debug' => 'отладка',
                'app_log_level_label_info' => 'информация',
                'app_log_level_label_notice' => 'уведомление',
                'app_log_level_label_warning' => 'предупреждение',
                'app_log_level_label_error' => 'ошибка',
                'app_log_level_label_critical' => 'критический',
                'app_log_level_label_alert' => 'предупреждение',
                'app_log_level_label_emergency' => 'аварийная ситуация',
                'app_url_label' => 'URL-адрес приложения',
                'app_url_placeholder' => 'URL-адрес приложения',
                'asset_url_label' => 'URL-адрес актива',
                'asset_url_placeholder' => 'URL-адрес актива',
                'db_connection_failed' => 'Не удалось подключиться к базе данных.',
                'db_connection_label' => 'Подключение к базе данных',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Хост базы данных',
                'db_host_placeholder' => 'Хост базы данных',
                'db_port_label' => 'Порт базы данных',
                'db_port_placeholder' => 'Порт базы данных',
                'db_name_label' => 'Имя базы данных',
                'db_name_placeholder' => 'Имя базы данных',
                'db_username_label' => 'Имя пользователя базы данных',
                'db_username_placeholder' => 'Имя пользователя базы данных',
                'db_password_label' => 'Пароль базы данных',
                'db_password_placeholder' => 'Пароль базы данных',

                'app_tabs' => [
                    'more_info' => 'Подробнее',
                    'broadcasting_title' => 'Трансляция, кэширование, сеанс и т. д. Очередь',
                    'broadcasting_label' => 'Драйвер вещания',
                    'broadcasting_placeholder' => 'Драйвер вещания',
                    'cache_label' => 'Драйвер кэша',
                    'cache_placeholder' => 'Драйвер кэша',
                    'filesystem_driver_label' => 'Драйвер файловой системы',
                    'filesystem_driver_placeholder' => 'Драйвер файловой системы',
                    'session_label' => 'Драйвер сеанса',
                    'session_placeholder' => 'Драйвер сеанса',
                    'queue_connection_label' => 'Соединение с очередью',
                    'queue_connection_placeholder' => 'Соединение с очередью',
                    'redis_label' => 'Драйвер Redis',
                    'redis_host' => 'Хост Redis',
                    'redis_password' => 'Пароль Redis',
                    'redis_port' => 'Redis-порт',

                    'mail_label' => 'Почта',
                    'mail_driver_label' => 'Почтовый драйвер',
                    'mail_driver_placeholder' => 'Драйвер почты',
                    'mail_host_label' => 'Почтовый хост',
                    'mail_host_placeholder' => 'Почтовый хост',
                    'mail_port_label' => 'Почтовый порт',
                    'mail_port_placeholder' => 'Почтовый порт',
                    'mail_username_label' => 'Имя пользователя почты',
                    'mail_username_placeholder' => 'Имя пользователя почты',
                    'mail_password_label' => 'Почтовый пароль',
                    'mail_password_placeholder' => 'Пароль почты',
                    'mail_encryption_label' => 'Шифрование почты',
                    'mail_encryption_placeholder' => 'Шифрование почты',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'Идентификатор ключа доступа Aws',
                    'aws_access_key_placeholder' => 'Идентификатор ключа доступа Aws',
                    'aws_secret_key_label' => 'Ключ доступа AWS',
                    'aws_secret_key_placeholder' => 'Ключ доступа AWS',
                    'aws_default_region_label' => 'Регион Aws по умолчанию',
                    'aws_default_region_placeholder' => 'Регион Aws по умолчанию',
                    'aws_bucket_label' => 'Корзина Aws',
                    'aws_bucket_placeholder' => 'Корзина AWS',
                    'aws_endpoint_label' => 'Aws Использовать конечную точку стиля пути',
                    'aws_endpoint_placeholder' => 'Aws использует конечную точку стиля пути',

                    'pusher_label' => 'Толкатель',
                    'pusher_app_id_label' => 'Идентификатор приложения Pusher',
                    'pusher_app_id_palceholder' => 'Идентификатор приложения Pusher',
                    'pusher_app_key_label' => 'Ключ приложения Pusher',
                    'pusher_app_key_palceholder' => 'Ключ приложения Pusher',
                    'pusher_app_secret_label' => 'Секрет приложения Pusher',
                    'pusher_app_secret_palceholder' => 'Секрет приложения Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Установить имя приложения.',
                    'app_environment' => 'Среда, которую вы хотите использовать в приложении.',
                    'app_debug' => "Определяет, сколько сведений об ошибке отображается пользователю на самом деле.",
                    'app_log_level' => "Установить уровень журнала приложения для приложения",
                    'app_url' => "Укажите URL-адрес приложения, который вы хотите.",
                    'db_connection' => 'Соединение с базой данных приложения.',
                    'db_host' => 'Установить хост базы данных приложения.',
                    'db_port' => 'Установите порт базы данных приложения.',
                    'db_name' => 'Имя базы данных, которую вы хотите использовать с W3mcs.',
                    'db_user_name' => 'Ваше имя пользователя базы данных.',
                    'db_password' => 'Пароль вашей базы данных.',
                ],
                'buttons' => [
                    'setup_database' => 'Настроить базу данных',
                    'setup_application' => 'Установить приложение',
                    'save' => 'Сохранить',
                    'installation' => 'Запустить установку',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Шаг 3 | Настройки среды | Классический редактор',
            'title' => 'Классический редактор окружения',
            'save' => 'Сохранить .env',
            'back' => 'Использовать мастер форм',
            'install' => 'Сохранить и установить',
        ],
        'success' => 'Настройки вашего файла .env сохранены.',
        'errors' => 'Не удалось сохранить файл .env, создайте его вручную.',
    ],

    'install' => 'Установить',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Установщик Laravel успешно УСТАНОВЛЕН на ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Установка завершена',
        'templateTitle' => 'Установка завершена',
        'finished' => 'Приложение успешно установлено.',
        'migration' => 'Миграция &amp; Исходный вывод консоли:',
        'console' => 'Вывод консоли приложения:',
        'log' => 'Запись в журнале установки:',
        'env' => 'Окончательный файл .env:',
        'exit' => 'Нажмите здесь, чтобы войти',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Настройка администратора'
        ],
        'name' => 'Полное имя',
        'name_description' => 'Введите полное имя пользователя, полное имя может содержать только буквенно-цифровые символы и т. д.',
        'email' => 'Электронная почта',
        'email_description' => 'Дважды проверьте свой адрес электронной почты, прежде чем продолжить.',
        'password' => 'Пароль',
        'password_description' => 'Важно! Этот пароль потребуется вам для входа в систему. Пожалуйста, сохраните его в безопасном месте.',
        'confirm_password' => 'Подтвердить пароль',
        'confirm_password_description' => 'Здесь еще раз подтвердите свой пароль.',
        'save' => 'Сохранить и войти',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Теперь свяжитесь с вашей базой данных, нажмите кнопку «Выполнить установку».'
        ],
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'Средство обновления Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title' => 'Добро пожаловать в средство обновления',
            'message' => 'Добро пожаловать в мастер обновлений.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title' => 'Обзор',
            'message' => 'Есть 1 обновление.|Имеется :number обновлений.',
            'install_updates' => 'Установить обновления',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Готово',
            'finished' => "База данных приложения успешно обновлена.",
            'exit' => 'Нажмите здесь, чтобы выйти',
        ],

        'log' => [
            'success_message' => 'Установщик Laravel успешно ОБНОВЛЕН на ',
        ],
    ],
];
