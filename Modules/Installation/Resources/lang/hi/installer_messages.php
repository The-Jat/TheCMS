<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'संस्करण',
    'title' => 'Laravel इंस्टालर',
    'next' => 'अगला कदम',
    'back' => 'पिछला',
    'finish' => 'स्थापित करें',
    'forms' => [
        'errorTitle' => 'निम्न त्रुटियाँ हुईं:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
         'templateTitle' => 'स्वागत है',
         'title' => 'Laravel इंस्टालर',
         'message' => 'आसान इंस्टालेशन और सेटअप विजार्ड',
         'next' => 'ज़रूरतों की जाँच करें',
         'choose_language' => 'भाषा चुनें',
         'verify_requirements' => 'आवश्यकताएँ सत्यापित करें',
         'setup_environment' => 'वातावरण स्थापित करें',
         'configure_site' => 'साइट कॉन्फ़िगर करें',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
         'templateTitle' => 'चरण 1 | सर्वर आवश्यकताएँ',
         'title' => 'सर्वर आवश्यकताएँ और अनुमतियाँ',
         'next' => 'अगला',
         'prev' => 'पिछला',
         'required' => 'आवश्यक',
         'error' => 'कृपया सर्वर आवश्यकताओं की जांच करें और अनुमति दें।'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
         'templateTitle' => 'चरण 2 | अनुमतियां',
         'title' => 'अनुमतियाँ',
         'next' => 'पर्यावरण कॉन्फ़िगर करें',
     ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'पर्यावरण सेटिंग सेटअप करें',
            'title' => 'पर्यावरण सेटिंग्स स्थापित करें',
            'wizard-button' => 'फ़ॉर्म विज़ार्ड सेटअप',
            'classic-button' => 'क्लासिक टेक्स्ट एडिटर',
        ],
        'wizard' => [
            'templateTitle' => 'तीसरा चरण | पर्यावरण सेटिंग्स | निर्देशित जादूगर',
            'step3_title' => 'पर्यावरण सेटिंग सेटअप करें',
            'step4_title' => 'डेटाबेस सेटिंग सेटअप करें',
            'step5_title' => 'एप्लिकेशन सेटिंग सेटअप करें',
            'step6_title' => 'एडमिन सेटिंग्स सेटअप करें',
            'step7_title' => 'सफलता',
            'step3_description' => 'कृपया चयन करें कि आप एप <code>.env</code> फ़ाइल को कैसे कॉन्फ़िगर करना चाहते हैं।',
            'step4_description' => 'नीचे आपको अपना डेटाबेस कनेक्शन विवरण दर्ज करना चाहिए। यदि आप इनके बारे में सुनिश्चित नहीं हैं, तो अपने मेज़बान से संपर्क करें।',
            'step5_description' => 'कृपया चुनें कि आप ऐप <code>.env</code> फ़ाइल को कैसे कॉन्फ़िगर करना चाहते हैं।',
            'step6_description' => 'नीचे आपको व्यवस्थापक के बारे में विवरण दर्ज करना चाहिए।',
            'step7_description' => 'W3cms स्थापित कर दिया गया है। धन्यवाद, और आनंद लें',
            'tabs' => [
                'environment' => 'पर्यावरण',
                'database' => 'डेटाबेस',
                'application' => 'आवेदन',
            ],
            'form' => [
                'name_required' => 'एक पर्यावरण नाम आवश्यक है।',
                'app_name_label' => 'ऐप का नाम',
                'app_name_placeholder' => 'ऐप का नाम',
                'app_environment_label' => 'एप्लिकेशन वातावरण',
                'app_environment_label_local' => 'स्थानीय',
                'app_environment_label_developement' => 'विकास',
                'app_environment_label_qa' => 'क्यूए',
                'app_environment_label_production' => 'उत्पादन',
                'app_environment_label_other' => 'अन्य',
                'app_environment_placeholder_other' => 'अपना परिवेश दर्ज करें...',
                'app_debug_label' => 'ऐप्लिकेशन डिबग',
                'app_debug_label_true' => 'सही',
                'app_debug_label_false' => 'गलत',
                'app_log_level_label' => 'एप्लिकेशन लॉग स्तर',
                'app_log_level_label_debug' => 'डीबग',
                'app_log_level_label_info' => 'जानकारी',
                'app_log_level_label_notice' => 'नोटिस',
                'app_log_level_label_warning' => 'चेतावनी',
                'app_log_level_label_error' => 'त्रुटि',
                'app_log_level_label_critical' => 'गंभीर',
                'app_log_level_label_alert' => 'अलर्ट',
                'app_log_level_label_emergency' => 'आपातकाल',
                'app_url_label' => 'एप्लिकेशन यूआरएल',
                'app_url_placeholder' => 'एप्लिकेशन यूआरएल',
                'asset_url_label' => 'एसेट यूआरएल',
                'asset_url_placeholder' => 'एसेट यूआरएल',
                'db_connection_failed' => 'डेटाबेस से जुड़ नहीं सका।',
                'db_connection_label' => 'डेटाबेस कनेक्शन',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'डाटाबेस होस्ट',
                'db_host_placeholder' => 'डाटाबेस होस्ट',
                'db_port_label' => 'डाटाबेस पोर्ट',
                'db_port_placeholder' => 'डाटाबेस पोर्ट',
                'db_name_label' => 'डेटाबेस का नाम',
                'db_name_placeholder' => 'डेटाबेस का नाम',
                'db_username_label' => 'डाटाबेस उपयोक्ता नाम',
                'db_username_placeholder' => 'डाटाबेस उपयोक्ता नाम',
                'db_password_label' => 'डाटाबेस पासवर्ड',
                'db_password_placeholder' => 'डाटाबेस पासवर्ड',

                'app_tabs' => [
                    'more_info' => 'अधिक जानकारी',
                    'broadcasting_title' => 'ब्रॉडकास्टिंग, कैशिंग, सेशन, &amp; कतार',
                    'broadcasting_label' => 'ब्रॉडकास्ट ड्राइवर',
                    'broadcasting_placeholder' => 'प्रसारण चालक',
                    'cache_label' => 'कैश ड्राइवर',
                    'cache_placeholder' => 'कैश ड्राइवर',
                    'filesystem_driver_label' => 'फ़ाइलसिस्टम ड्राइवर ड्राइवर',
                    'filesystem_driver_placeholder' => 'फाइलसिस्टम ड्राइवर ड्राइवर',
                    'session_label' => 'सेशन ड्राइवर',
                    'session_placeholder' => 'सेशन ड्राइवर',
                    'queue_connection_label' => 'कनेक्शन कतार',
                    'queue_connection_placeholder' => 'कनेक्शन कतार',
                    'redis_label' => 'रेडिस ड्राइवर',
                    'redis_host' => 'रेडिस होस्ट',
                    'redis_password' => 'रेडिस पासवर्ड',
                    'redis_port' => 'रेडिस पोर्ट',

                    'mail_label' => 'मेल',
                    'mail_driver_label' => 'मेल चालक',
                    'mail_driver_placeholder' => 'मेल चालक',
                    'mail_host_label' => 'मेल होस्ट',
                    'mail_host_placeholder' => 'मेल होस्ट',
                    'mail_port_label' => 'मेल पोर्ट',
                    'mail_port_placeholder' => 'मेल पोर्ट',
                    'mail_username_label' => 'मेल उपयोक्तानाम',
                    'mail_username_placeholder' => 'मेल उपयोक्तानाम',
                    'mail_password_label' => 'मेल पासवर्ड',
                    'mail_password_placeholder' => 'मेल पासवर्ड',
                    'mail_encryption_label' => 'मेल एन्क्रिप्शन',
                    'mail_encryption_placeholder' => 'मेल एन्क्रिप्शन',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'Aws एक्सेस कुंजी आईडी',
                    'aws_access_key_placeholder' => 'Aws एक्सेस कुंजी आईडी',
                    'aws_secret_key_label' => 'Aws एक्सेस कुंजी',
                    'aws_secret_key_placeholder' => 'Aws एक्सेस कुंजी',
                    'aws_default_region_label' => 'Aws डिफ़ॉल्ट क्षेत्र',
                    'aws_default_region_placeholder' => 'Aws डिफ़ॉल्ट क्षेत्र',
                    'aws_bucket_label' => 'Aws बकेट',
                    'aws_bucket_placeholder' => 'Aws बकेट',
                    'aws_endpoint_label' => 'Aws पाथ स्टाइल एंडपॉइंट का प्रयोग करें',
                    'aws_endpoint_placeholder' => 'Aws पाथ स्टाइल एंडपॉइंट का प्रयोग करें',

                    'pusher_label' => 'पुशर',
                    'pusher_app_id_label' => 'पुशर एप आईडी',
                    'pusher_app_id_palceholder' => 'पुशर ऐप आईडी',
                    'pusher_app_key_label' => 'पुशर ऐप कुंजी',
                    'pusher_app_key_palceholder' => 'पुशर ऐप कुंजी',
                    'pusher_app_secret_label' => 'पुशर एप सीक्रेट',
                    'pusher_app_secret_palceholder' => 'पुशर एप सीक्रेट',
                ],
                'input_labels' => [
                    'app_name' => 'एप्लिकेशन का नाम सेट करें',
                    'app_environment' => 'वह वातावरण जिसे आप एप्लिकेशन में उपयोग करना चाहते हैं।',
                    'app_debug' => "यह परिभाषित करता है कि उपयोगकर्ता को वास्तव में त्रुटि का कितना विवरण प्रदर्शित होता है।",
                    'app_log_level' => "एप्लिकेशन का ऐप लॉग स्तर सेट करें",
                    'app_url' => "ऐप्लिकेशन का वह यूआरएल सेट करें जो आप चाहते हैं।",
                    'db_connection' => 'एप्लिकेशन का डेटाबेस कनेक्शन',
                    'db_host' => 'एप्लिकेशन का डेटाबेस होस्ट सेट करें।',
                    'db_port' => 'एप्लिकेशन का डेटाबेस पोर्ट सेट करें।',
                    'db_name' => 'डेटाबेस का नाम जिसे आप W3mcs के साथ प्रयोग करना चाहते हैं।',
                    'db_user_name' => 'आपका डेटाबेस उपयोगकर्तानाम',
                    'db_password' => 'आपका डेटाबेस पासवर्ड',
                ],
                'buttons' => [
                    'setup_database' => 'डाटाबेस तैयार करें',
                    'setup_application' => 'आवेदन की स्थापना',
                    'save' => 'सेव',
                    'installation' => 'स्थापना चलाएँ',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'तीसरा चरण | पर्यावरण सेटिंग्स | क्लासिक संपादक',
            'title' => 'क्लासिक पर्यावरण संपादक',
            'save' => 'सेव .env',
            'back' => 'फॉर्म विज़ार्ड का प्रयोग करें',
            'install' => 'सहेजें और स्थापित करें',
        ],
        'success' => 'आपकी .env फ़ाइल सेटिंग्स सहेज ली गई हैं।',
        'errors' => '.env फ़ाइल को सहेजने में असमर्थ, कृपया इसे मैन्युअल रूप से बनाएँ।',
    ],

    'install' => 'इंस्टॉल',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel इंस्टालर सफलतापूर्वक स्थापित किया गया ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'स्थापना समाप्त',
        'templateTitle' => 'स्थापना समाप्त',
        'finished' => 'एप्लिकेशन सफलतापूर्वक स्थापित किया गया है।',
        'migration' => 'माइग्रेशन और amp; बीज कंसोल आउटपुट:',
        'console' => 'एप्लिकेशन कंसोल आउटपुट:',
        'log' => 'स्थापना लॉग प्रविष्टि:',
        'env' => 'अंतिम .env फ़ाइल:',
        'exit' => 'लॉग इन करने के लिए यहां क्लिक करें',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'एडमिन सेटअप'
        ],
        'name' => 'पूरा नाम',
        'name_description' => 'उपयोगकर्ता का पूरा नाम दर्ज करें, पूरे नाम में केवल अल्फ़ान्यूमेरिक वर्ण आदि हो सकते हैं',
        'email' => 'ईमेल',
        'email_description' => 'जारी रखने से पहले अपने ईमेल पते की दोबारा जांच करें।',
        'password' => 'पासवर्ड',
        'password_description' => 'महत्वपूर्ण: लॉग इन करने के लिए आपको इस पासवर्ड की आवश्यकता होगी। कृपया इसे सुरक्षित स्थान पर संग्रहीत करें।',
        'confirm_password' => 'पासवर्ड की पुष्टि करें',
        'confirm_password_description' => 'यहाँ फिर से अपने पासवर्ड की पुष्टि करें।',
        'save' => 'सेव करें और लॉग इन करें',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'अब अपने डेटाबेस के साथ संवाद करें, रन इंस्टॉलेशन बटन पर क्लिक करें।'
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
        'title' => 'लारवेल अपडेटर',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Laravel अपडेटर में आपका स्वागत है',
            'message' => 'अपडेट विज़ार्ड में आपका स्वागत है।',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title' => 'अवलोकन',
             'message' => '1 अपडेट है.|ये हैं :नंबर अपडेट',
             'install_updates' => 'अद्यतन स्थापित करें',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'समाप्त',
            'finished' => 'एप्लिकेशन का डेटाबेस सफलतापूर्वक अपडेट कर दिया गया है।',
            'exit' => 'बाहर निकलने के लिए यहां क्लिक करें',
        ],

        'log' => [
            'success_message' => 'Laravel इंस्टॉलर को सफलतापूर्वक अपडेट किया गया ',
        ],
    ],
];
