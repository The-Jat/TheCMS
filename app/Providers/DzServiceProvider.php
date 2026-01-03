<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use App\Models\Configuration;

class DzServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once app_path() . '/Helper/DzHelper.php';
        require_once app_path() . '/Helper/HelpDesk.php';
        require_once app_path() . '/Helper/Acl.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->config_handler();
 
        // Create a class alias 'MagicEditorElements' of theme elements to use anywhere directly.
        $currentTheme = \DzHelper::getFrontendThemeName();
        $classNamespace = 'Themes\\frontend\\' . $currentTheme . '\\includes\\MagicEditor\\ElementsClass';
        $BlogOptionsClassNamespace = 'Themes\\frontend\\' . $currentTheme . '\\includes\\W3Options\\BlogOptionsClass';
        $PageOptionsClassNamespace = 'Themes\\frontend\\' . $currentTheme . '\\includes\\W3Options\\PageOptionsClass';
        AliasLoader::getInstance()->alias('MagicEditorElements', $classNamespace);
        AliasLoader::getInstance()->alias('ThemeBlogOptions', $BlogOptionsClassNamespace);
        AliasLoader::getInstance()->alias('ThemePageOptions', $PageOptionsClassNamespace);

    }

    /*
    * Load all configuration data
    */
    private function config_handler()
    {
        try {
            \DB::connection()->getPdo();
            
            if(\Schema::hasTable('configurations')) 
            {
                $configuration = new Configuration();
                $configuration->init();
            }

        } catch (\Exception $e) {
        }
    }
}
