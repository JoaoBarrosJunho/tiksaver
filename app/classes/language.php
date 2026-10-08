<?php

namespace App\classes;

class language
{

    public static $langs = ['en' => 'English', 'de' => 'Deutsch', 'es' => 'Spanish', 'pt' => 'Portuguese', 'fr' => "French", 'ru' => 'Russian', 'ar' => 'Arabic', 'hi' => 'Hindi', 'tr'=>'Turkish','pl'=>'Polish'];

    /**
     * Principal method to set website language
     * @param int $mode - 1 (manual set), 2 automatic, default seted by admin
     */
    public static function setLang($mode = null, $value = '')
    {

        switch ($mode) {
            case 1:
                //manual
                if (self::verifyLang($value)) {
                    return  self::setLangCoockie($value);
                } else {
                    return  self::verifyLang(leemclasses::option('site_language')) ? self::setLangCoockie(leemclasses::option('site_language')) : self::setLangCoockie('en');
                }

                break;
            default:
                #by Admin
                return  self::verifyLang(leemclasses::option('site_language')) ? self::setLangCoockie(leemclasses::option('site_language')) : self::setLangCoockie('en');

                break;
        }
    }

    //SET COOKIE LANGUEGE
    private static function setLangCoockie($value)
    {
        if (setcookie('lang', "$value", time() + 606024 * 30)) {
            return true;
        } else {
            return false;
        }
    }

    //VERIFY IF LANG EXIST
    private static function verifyLang($value)
    {
        $langs = self::$langs;
        $file = SITE_ROOT . "/locale/$value.php";

        return file_exists($file) && in_array($value, array_keys($langs)) ? true : false;
    }


    //GET THE LANG
    public static function getLang()
    {
        $lang = isset($_COOKIE['lang']) && !empty($_COOKIE['lang']) ? $_COOKIE['lang'] : self::checkC2Lang();
        $langs = self::$langs;

        return in_array($lang, array_keys($langs)) ? $lang : 'en';
    }

    public static function checkC2Lang()
    {
        $cc2 = isset($_SERVER['HTTP_CF_IPCOUNTRY']) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : 'none';
        $countrys = array(
            "AO" => "PT",
            "BR" => "PT",
            "PT" => "PT",
            "CV" => "PT",
            "ST" => "PT",
            "GB" => "EN",
            "US" => "EN",
            "CA" => "EN",
            "AU" => "EN",
            "NZ" => "EN",
            "IE" => "EN",
            "ZA" => "EN",
            "ES" => "ES",
            "MX" => "ES",
            "AR" => "ES",
            "CL" => "ES",
            "CO" => "ES",
            "PE" => "ES",
            "VE" => "ES",
            "DE" => "DE",
            "AT" => "DE",
            "CH" => "DE",
            "FR" => "FR",
            "BE" => "FR",
            "CA" => "FR",
            "CH" => "FR",
            "LU" => "FR",
            "IN" => "HI",
            "AE" => "AR",
            "BH" => "AR",
            "DJ" => "AR",
            "DZ" => "AR",
            "EG" => "AR",
            "EH" => "AR",
            "IQ" => "AR",
            "JO" => "AR",
            "KM" => "AR",
            "KW" => "AR",
            "LB" => "AR",
            "LY" => "AR",
            "MA" => "AR",
            "MR" => "AR",
            "OM" => "AR",
            "PS" => "AR",
            "QA" => "AR",
            "SA" => "AR",
            "SD" => "AR",
            "SO" => "AR",
            "SY" => "AR",
            "TD" => "AR",
            "TN" => "AR",
            "YE" => "AR",
            "RU" => "RU",
            "BY" => "RU",
            "KZ" => "RU",
            "KG" => "RU",
            "UA" => "RU",
            "MD" => "RU",
            "TM" => "RU",
            "UZ" => "RU",
            "GE" => "RU",
            "LV" => "RU",
            "LT" => "RU",
            "EE" => "RU",
            "AM" => "RU",
            "AZ" => "RU",
            "TR"=>"TR",
            "PL"=>"PL"
        );

        return isset($countrys[$cc2]) ? strtolower($countrys[$cc2]) : leemclasses::option('site_language');
    }
}
