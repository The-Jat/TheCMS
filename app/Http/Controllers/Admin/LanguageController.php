<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Country;
use Illuminate\Http\Request;
use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->isMethod('post'))
        {
            $language = $request->input('language_hidden');
            $file = $request->input('file_name_hidden');
            $langauge_file = $request->input('language');
            $languageStr = '';
            if(!empty($langauge_file))
            {
                foreach ($langauge_file as $key => $value) {
                    if(is_array($value))
                    {
                        $languageStr .= "'" . $key . "'" . " => "."[\n\t";

                        foreach ($value as $subKey => $subValue) {
                            $subValue = \Str::replace("'", "\'", $subValue);
                            $languageStr .= "\t'" . $subKey . "'" . " => "."'" . $subValue."',\n\t";
                        }

                        $languageStr .= "],\n\t";
                    }
                    else
                    {
                        $value = \Str::replace("'", "\'", $value);
    					$languageStr .= "'" . $key . "'" . " => "."'" . $value."',\n\t";
                    }
                }
            }

            $contents = "<?php \n\nreturn [ \n\n\t".$languageStr."\n];";

            $filePath = base_path('lang') . '/' . $language . '/' . $file . '.php';
            return file_put_contents($filePath, $contents);

        }
        $page_title = __('common.languages');

        $allinstalledlanguage = $this->getLanguages();
        $allfiles = $this->getLanguageFiles('en');
        $alllanguages = config('lang.default');
        $languages =  array_diff_key($alllanguages,$allinstalledlanguage);
        $langKeysArray = array_keys($languages);
        $installed_language = array_intersect_key($alllanguages,$allinstalledlanguage);
        return view('admin.languages.index', compact('page_title', 'languages','allfiles','installed_language','alllanguages','langKeysArray'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $translations   = Null;
        if($request->isMethod('post'))
        {
            $language       = $request->input('language');
            $file_name           = $request->input('file_name');
            $translations   = $this->getTranslations($language, $file_name);
        }
        return view('admin.languages.show', compact('translations'));

    }

    public function translate(Request $request)
    {
        $apiKey = env('GOOGLE_TRANSLATION_API_KEY');
        $text = $request->input('text');
        $targetLanguage = $request->input('lang_type');

        $translate = new TranslateClient([
            'key' => $apiKey
        ]);

        $translation = $translate->translate($text, [
            'target' => $targetLanguage
        ]);

        return response()->json([
            'original' => $text,
            'translation' => $translation['text']
        ]);
    }

    public function add_language(Request $request)
    {
        if($request->input('new_language')==''){
            return redirect()->back();
        }
        $language = $request->input('new_language');
        $url = config('constants.language_api');
        $response = Http::withHeaders([
            'User-Agent'    => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
        ])->get($url, ['filename' => $language]);

        $lang_file = optional($response->object())->language_file;
        $lang_path = lang_path(basename($lang_file));

        $ch = curl_init($lang_file);
        $fp = fopen($lang_path, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        // Extract the file
        $zip = new ZipArchive;
        if ($zip->open($lang_path) === true) {
            $zip->extractTo(lang_path());
            $zip->close();
            unlink($lang_path);
            return redirect()->back()->with(['language' => $language, 'success' => __('Language Added successfully.')]);
        }

    }

    private function getLanguages()
    {
        $langBasePath = base_path('lang');
        $files = scandir($langBasePath);

        $languages = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $language = pathinfo($file, PATHINFO_FILENAME);
                $languages[$language] = $this->getLanguageFiles($language);
            }
        }
        return $languages;
    }

    private function getTranslations($language, $file)
    {
        $filePath = base_path('lang') . '/' . $language . '/' . $file . '.php';
        if (file_exists($filePath)) {
            return require $filePath;
        }

        return [];
    }

    private function getLanguageFiles($language)
    {
        $langBasePath = base_path('lang').'/'.$language;
        $files = scandir($langBasePath);

        $langFiles = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $langFiles[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $langFiles;

    }


}
