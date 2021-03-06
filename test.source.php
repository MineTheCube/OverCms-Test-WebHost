<?php

header('Content-Type: text/html; charset=UTF-8');
$s = microtime(true);

/* N'affiche aucune erreur */
function_exists('error_reporting') && error_reporting(0);
function_exists('ini_set') && ini_set("display_errors", 0);

/* Affiche toutes les erreurs */
// error_reporting(E_ALL);
// ini_set('display_errors', true);

$a = array(array(
        'Base de données (au moins un des deux doit fonctionner)', array(
        'MySQL' => function_exists('extension_loaded') && extension_loaded('pdo_mysql'),
        'SQLite' => function_exists('extension_loaded') && extension_loaded('pdo_sqlite')
    )), array(
        'Fonctionnalités requises', array(
        'Version de PHP' => version_compare(PHP_VERSION, '5.2.0', '>'),
        'Requête HTTP' => _crl("http://code.jquery.com/jquery-latest.min.js") || _crl("https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"),
        'Fonctions avancées' => _adv(),
        'Gestion des fichiers/archives' => _fls() && _zip(),
        'Encryptage' => _rsa() && _mbc(),
        'Création d\'image' => _img(),
    )), array(
        'Fonctionnalités optionnelles', array(
        'URL Rewrite (Apache)' => strpos(strtolower($_SERVER["SERVER_SOFTWARE"]), 'apache') !== false,
        'Ports ouverts et sockets' => function_exists('fsockopen') && _crl("http://portquiz.net", 20070),
)));

$_ok = (($a[0][1]['MySQL'] || $a[0][1]['SQLite']) && !in_array(false, $a[1][1]));

//////////////////////////////////////////////////////////////////////

$y = '<img src="data:image/x-icon;base64,'.
     'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2V'.
     'SZWFkeXHJZTwAAAGrSURBVDjLvZPZLkNhFIV75zjvYm7VGFNCqoZUJ+roKUUpjRuqp61Wq0NKDMelGGqOxBSUIBKXWtWGZxAvobr8lW'.
     'jChRgSF//dv9be+9trCwAI/vIE/26gXmviW5bqnb8yUK028qZjPfoPWEj4Ku5HBspgAz941IXZeze8N1bottSo8BTZviVWrEh546EO0'.
     '3EXpuJOdG63otJbjBKHkEp/Ml6yNYYzpuezWL4s5VMtT8acCMQcb5XL3eJE8VgBlR7BeMGW9Z4yT9y1CeyucuhdTGDxfftaBO7G4L+z'.
     'g91UocxVmCiy51NpiP3n2treUPujL8xhOjYOzZYsQWANyRYlU4Y9Br6oHd5bDh0bCpSOixJiWx71YY09J5pM/WEbzFcDmHvwwBu2wni'.
     'kg+lEj4mwBe5bC5h1OUqcwpdC60dxegRmR06TyjCF9G9z+qM2uCJmuMJmaNZaUrCSIi6X+jJIBBYtW5Cge7cd7sgoHDfDaAvKQGAlRZ'.
     'Yc6ltJlMxX03UzlaRlBdQrzSCwksLRbOpHUSb7pcsnxCCwngvM2Rm/ugUCi84fycr4l2t8Bb6iqTxSCgNIAAAAAElFTkSuQmCC'.
     '" alt="Oui"/>';
$n = '<img src="data:image/x-icon;base64,'.
     'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2V'.
     'SZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2Ot'.
     'PlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSv'.
     'X+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65Whbm'.
     'rnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4'.
     'NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7u'.
     'KS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQ'.
     'd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS'.
     '9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg=='.
     '" alt="Non"/>';


/////////////////////////////////////////////////////////////////////

function is_disabled($functionList) {
    foreach (explode(' ', $functionList) as $function)
        if (!function_exists($function)) return true;
    return false;
}

function _crl($url, $port = 0) {
    if (is_disabled('curl_init') || !extension_loaded('curl')) return false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($port) curl_setopt($ch, CURLOPT_PORT, $port);
    $output = curl_exec($ch);
    curl_close($ch);
    return !empty($output);
}

function _adv() {
    if (is_disabled('ini_get ini_set error_reporting move_uploaded_file')) return false;
    if (filter_var(ini_get('safe_mode'), FILTER_VALIDATE_BOOLEAN)) return false;
    $d = ini_get('session.name');
    if (empty($d)) return false;
    $r = ini_set('session.name', 'PHP_SESSION_CUSTOM');
    if ($r === false || ini_get('session.name') !== 'PHP_SESSION_CUSTOM') return false;
    $r = ini_set('session.name', $d);
    return is_string($r);
}

function _fls() {
    if (is_disabled('mkdir rmdir unlink chmod rename copy')) return false;
    $r = chmod(dirname(__FILE__), 0755);
    if (!$r) return false;
    $r = delete_directory('test-overcms-files');
    if (!$r) return false;
    $r = mkdir('test-overcms-files') && chmod('test-overcms-files', 0755);
    if (!$r) return false;
    $rd = md5(time().rand(1,9999));
    $r = file_put_contents('test-overcms-files/new-file.txt', $rd) && chmod('test-overcms-files/new-file.txt', 0755);
    if (!$r) return false;
    $r = rename('test-overcms-files/new-file.txt', 'test-overcms-files/data.txt');
    if (!$r) return false;
    $r = copy('test-overcms-files/data.txt', 'test-overcms-files/useless.txt');
    if (!$r) return false;
    $fp = fopen('test-overcms-files/data.txt', 'rw');
    if (!is_resource($fp)) return false;
    if (fread($fp, 1024) !== $rd) return false;
    $r = fclose($fp);
    if (!$r) return false;
    $r = unlink("test-overcms-files/data.txt") && unlink("test-overcms-files/useless.txt");
    if (!$r) return false;
    $r = delete_directory('test-overcms-files');
    if (!$r) return false;
    return true;
}

function _zip() {
    $r = file_put_contents('test-overcms-files-data.zip', base64_decode(
        'UEsDBAoAAAAIAHUKcEaSYDpXJwAAACUAAAAIAAAAZGF0YS50eHTLL0stSs4tVqjKLFBIrShJzSvOzM9TyCxWKM8vys7MS1dIy8xLBQBQSwECCgAKAAAACAB1CnBGkmA6VycAAAAlAAAACAAAAAAAAAAAACAAAAAAAAAAZGF0YS50eHRQSwUGAAAAAAEAAQA2AAAATQAAAAAA'
    ));
    if (!$r || !class_exists('ZipArchive')) return false;
    $zip = new ZipArchive;
    $a = false;
    if ($zip->open('test-overcms-files-data.zip') === true) {
        $stat = $zip->statIndex(0);
        $n = $stat['name'];
        $fp = $zip->getStream($n);
        if (!$fp) return false;
        $r = fread($fp, 1024);
        fclose($fp);
        $a = ($r === 'overcms zip extension is working fine' && $n === 'data.txt');
    }
    $zip->close();
    if (is_file('test-overcms-files-data.zip'))
        unlink('test-overcms-files-data.zip');
    return $a;
}

function _rsa() {
    if (is_disabled('openssl_pkey_new openssl_pkey_export openssl_sign openssl_verify mcrypt_create_iv')) return false;
    $res = openssl_pkey_new(array("private_key_bits" => 2048));
    openssl_pkey_export($res, $private_key);
    $public_key = openssl_pkey_get_details($res);
    $public_key = $public_key["key"];
    if (empty($public_key) || empty($private_key)) return false;
    $rand = mcrypt_create_iv(10, MCRYPT_DEV_URANDOM);
    $pkeyid = openssl_get_privatekey($private_key);
    openssl_sign($rand, $sign, $pkeyid);
    openssl_free_key($pkeyid);
    $signature = base64_encode($rand . $sign);
    if (empty($signature) || empty($rand)) return false;
    $tmp = base64_decode($signature);
    $rand = substr($tmp, 0, 10);
    $signature = substr($tmp, 10);
    $pubkeyid = openssl_get_publickey($public_key);
    $verify = openssl_verify($rand, $signature, $pubkeyid);
    openssl_free_key($pubkeyid);
    return ($verify === 1);
}

function _mbc() {
    if (is_disabled('mcrypt_encrypt mcrypt_create_iv mcrypt_get_iv_size mcrypt_decrypt')) return false;
    $k = md5(rand(1,10000).time());
    $d = 'overcms crypt extension is working fine';
    $e = trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $k, $d, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    return $d === trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $k, base64_decode($e), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function _img() {
    if (!extension_loaded('gd')) return false;
    if (is_disabled('gd_info imagettftext imagecreatefromstring imagejpeg getimagesize')) return false;
    $g = gd_info();
    if ($g['PNG Support'] !== true || $g['JPEG Support'] !== true) return false;
    $data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
          . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
          . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
          . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
    $im = @imagecreatefromstring(base64_decode($data));
    if (!is_resource($im)) return false;
    return (imagesx($im) === 28 && imagesy($im) === 18);
}

function delete_directory($dir) {
    $dir = rtrim($dir, DIRECTORY_SEPARATOR);
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
    chmod($dir, 0755);
    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') continue;
        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $file)) return false;
    }
    return rmdir($dir);
}

?><!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test de l'hébergeur - OverCms</title>
        <meta name="description" content="OverCms - Test de l'hébergeur">
        <link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAMjSURBVHjaxNdLaF1VFAbgLzGtKYL1LcrWIqgDKxEFLfiiClp8YVFEkfrYRkSKFKmUHBykIFa2oAUFEUQ8KIrVgeDAgTrTQgdaBMUUW4tWjhaJpS+1JH1cJ/vKyTW5vfcmqf/kwFnr7PXvdfb619p9jUbD/4mBExksxDSAa/E8/qzK4vaBExh4CdYhYiEOznsGQkz9OB0P4VmcXTNvn1cCIaZTsRzP4YppXH6aFwIhplNwGUZwbxvXuSUQYlqAS/AY1mBBNh3BXizO/76JsTkjEGIKuBsFQs00iS1oYFntfWNOCISYzsxlNYLrWsyH8CF243Esqtn2YFfPBEJMg7gaw3hkGpe/8Sq+wkac1WLfiQM9EQgxLcUDWI0zpnHZn0/+J3g/138rfsm/oXMCIaYluBVPYWgGt91Yj3fxAa5sUwHHOiIQYjoNN+MJrGjjugPrqrL4OMT0Ju5q4/s9jrYlEGLqw01YhQdxcpsFv8baqiy+DDGN4uE2vg1sq8piZgIhpstxX9btC46TpE/zzr8LMa3C2poGTIc9+Qz8txuGmM7BnTndyzo4Gu9gfVUWP4eYrseGLDjtsBN/TSEQYjoJd+Syuu04O4DDeAUvVmXxR4jpUryMCzsg/W8F1DOwEffj3A4W2J/7+WtVWRzKWduAazosqB+zPE8hcFWHwX/FSFUW7+XMLcIzWNmFlIzVCfTn5+qs45+3+XAbhpvBMx7Fk10K2vamBkBffSYMMV2UU3lLbi5NCd2Mp6uy2FrzXYES53UR/ACGqrLYNS2BFvEZyjqwGK9XZbGjpUw3YWmXSv4DbqjKYrztUFqVxT58EWLagsGqLA7Wgp+Pl3oI3kz/ZMdTcVUWh3PJ1XViNPeEXvBtK4H+Lhe4OJdrX48ExmZLYGCGrP1Wl9d2GtDsAb0SaDS7WIu0DuPGPPlsnuHbfRhvfdlvdmgOH5/l0nob92Qyb2V7E3sxMZdXs6NZ/zdVZXEsH9ojeZfjIaZv8EJWyZX4KJOYgr5uLqchpuW5/S7EG1hTlcVEB+P6ICaqspicbQZ+x9b8HD1e8OlKeVYZmA/8MwDGXPtGWavKjQAAAABJRU5ErkJggg==">
        <style type="text/css">
        /*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */
        html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background-color:transparent}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:bold}dfn{font-style:italic}h1{font-size:2em;margin:.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-0.5em}sub{bottom:-0.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{box-sizing:content-box;height:0}pre{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}button{overflow:visible}button,select{text-transform:none}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input{line-height:normal}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0}input[type="number"]::-webkit-inner-spin-button,input[type="number"]::-webkit-outer-spin-button{height:auto}input[type="search"]{-webkit-appearance:textfield;box-sizing:content-box}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}textarea{overflow:auto}optgroup{font-weight:bold}table{border-collapse:collapse;border-spacing:0}td,th{padding:0}html{-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}*,*:before,*:after{-webkit-box-sizing: inherit;-moz-box-sizing: inherit;box-sizing: inherit;}

        h1, h2, h3, p {
            margin: 15px 0;
        }

        h2, h3 {
            font-weight: normal;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            color: #525252;
            font-family: "Trebuchet MS", Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            background: #f7f7f7;
        }

        #main {
            height: 100%;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            background-color: #f7f7f7;
            background-image: url('data:image/jpg;base64,/9j/4AAQSkZJRgABAgEASABIAAD/4QPiRXhpZgAATU0AKgAAAAgABwESAAMAAAABAAEAAAEaAAUAAAABAAAAYgEbAAUAAAABAAAAagEoAAMAAAABAAIAAAExAAIAAAAcAAAAcgEyAAIAAAAUAAAAjodpAAQAAAABAAAApAAAANAACvyAAAAnEAAK/IAAACcQQWRvYmUgUGhvdG9zaG9wIENTNCBXaW5kb3dzADIwMTU6MDU6MjUgMTY6NDM6MTEAAAAAA6ABAAMAAAAB//8AAKACAAQAAAABAAAD6KADAAQAAAABAAAACgAAAAAAAAAGAQMAAwAAAAEABgAAARoABQAAAAEAAAEeARsABQAAAAEAAAEmASgAAwAAAAEAAgAAAgEABAAAAAEAAAEuAgIABAAAAAEAAAKsAAAAAAAAAEgAAAABAAAASAAAAAH/2P/gABBKRklGAAECAABIAEgAAP/tAAxBZG9iZV9DTQAC/+4ADkFkb2JlAGSAAAAAAf/bAIQADAgICAkIDAkJDBELCgsRFQ8MDA8VGBMTFRMTGBEMDAwMDAwRDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAENCwsNDg0QDg4QFA4ODhQUDg4ODhQRDAwMDAwREQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgAAgCgAwEiAAIRAQMRAf/dAAQACv/EAT8AAAEFAQEBAQEBAAAAAAAAAAMAAQIEBQYHCAkKCwEAAQUBAQEBAQEAAAAAAAAAAQACAwQFBgcICQoLEAABBAEDAgQCBQcGCAUDDDMBAAIRAwQhEjEFQVFhEyJxgTIGFJGhsUIjJBVSwWIzNHKC0UMHJZJT8OHxY3M1FqKygyZEk1RkRcKjdDYX0lXiZfKzhMPTdePzRieUpIW0lcTU5PSltcXV5fVWZnaGlqa2xtbm9jdHV2d3h5ent8fX5/cRAAICAQIEBAMEBQYHBwYFNQEAAhEDITESBEFRYXEiEwUygZEUobFCI8FS0fAzJGLhcoKSQ1MVY3M08SUGFqKygwcmNcLSRJNUoxdkRVU2dGXi8rOEw9N14/NGlKSFtJXE1OT0pbXF1eX1VmZ2hpamtsbW5vYnN0dXZ3eHl6e3x//aAAwDAQACEQMRAD8A2El4kktR499rdwVfs5H0l4KkhLovx9fo+8VfnIdvK8LSQ6rj8r7Z3PPfhM/j5heKJJzC+1Hsi43Lvocfnf8AfV4gkkdkx+Z97HH9yG/leEJJgZzs+2DvwjM/mm/995XhqScWGH7H3W75fxQm/JeHpIDZdL5n3Ac9kT8w8LwtJEqD7ceExXiSSKwv/9n/7QjIUGhvdG9zaG9wIDMuMAA4QklNBCUAAAAAABAAAAAAAAAAAAAAAAAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAIASAAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAeDhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAjhCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAzhCSU0EAgAAAAAACAAAAAAAAAAAOEJJTQQwAAAAAAAEAQEBAThCSU0ELQAAAAAABgABAAAABThCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANNAAAABgAAAAAAAAAAAAAACgAAA+gAAAAMAFMAYQBuAHMAIAB0AGkAdAByAGUALQAyAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAPoAAAACgAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAABAAAAABAAAAAAAAbnVsbAAAAAIAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAACgAAAABSZ2h0bG9uZwAAA+gAAAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNl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IiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIiB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M0IFdpbmRvd3MiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTUtMDUtMjVUMTY6NDM6MTErMDI6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDE1LTA1LTI1VDE2OjQzOjExKzAyOjAwIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxNS0wNS0yNVQxNjo0MzoxMSswMjowMCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNUNGNkUxQUVBMDJFNTExQjAzRkU2MzJEMjcwMDI2QSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNENGNkUxQUVBMDJFNTExQjAzRkU2MzJEMjcwMDI2QSIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOkI0Q0Y2RTFBRUEwMkU1MTFCMDNGRTYzMkQyNzAwMjZBIiBkYzpmb3JtYXQ9ImltYWdlL2pwZWciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHRpZmY6T3JpZW50YXRpb249IjEiIHRpZmY6WFJlc29sdXRpb249IjcyMDAwMC8xMDAwMCIgdGlmZjpZUmVzb2x1dGlvbj0iNzIwMDAwLzEwMDAwIiB0aWZmOlJlc29sdXRpb25Vbml0PSIyIiB0aWZmOk5hdGl2ZURpZ2VzdD0iMjU2LDI1NywyNTgsMjU5LDI2MiwyNzQsMjc3LDI4NCw1MzAsNTMxLDI4MiwyODMsMjk2LDMwMSwzMTgsMzE5LDUyOSw1MzIsMzA2LDI3MCwyNzEsMjcyLDMwNSwzMTUsMzM0MzI7QkQ1OTA5MERCM0I0RDE2REIxQUE3NzM1OEYyMTQ1RjQiIGV4aWY6UGl4ZWxYRGltZW5zaW9uPSIxMDAwIiBleGlmOlBpeGVsWURpbWVuc2lvbj0iMTAiIGV4aWY6Q29sb3JTcGFjZT0iNjU1MzUiIGV4aWY6TmF0aXZlRGlnZXN0PSIzNjg2NCw0MDk2MCw0MDk2MSwzNzEyMSwzNzEyMiw0MDk2Miw0MDk2MywzNzUxMCw0MDk2NCwzNjg2NywzNjg2OCwzMzQzNCwzMzQzNywzNDg1MCwzNDg1MiwzNDg1NSwzNDg1NiwzNzM3NywzNzM3OCwzNzM3OSwzNzM4MCwzNzM4MSwzNzM4MiwzNzM4MywzNzM4NCwzNzM4NSwzNzM4NiwzNzM5Niw0MTQ4Myw0MTQ4NCw0MTQ4Niw0MTQ4Nyw0MTQ4OCw0MTQ5Miw0MTQ5Myw0MTQ5NSw0MTcyOCw0MTcyOSw0MTczMCw0MTk4NSw0MTk4Niw0MTk4Nyw0MTk4OCw0MTk4OSw0MTk5MCw0MTk5MSw0MTk5Miw0MTk5Myw0MTk5NCw0MTk5NSw0MTk5Niw0MjAxNiwwLDIsNCw1LDYsNyw4LDksMTAsMTEsMTIsMTMsMTQsMTUsMTYsMTcsMTgsMjAsMjIsMjMsMjQsMjUsMjYsMjcsMjgsMzA7MDk3ODRGQjcwOERBNjkwRUZBQzU1MjlBRkFDREI2RUUiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOkI0Q0Y2RTFBRUEwMkU1MTFCMDNGRTYzMkQyNzAwMjZBIiBzdEV2dDp3aGVuPSIyMDE1LTA1LTI1VDE2OjQzOjExKzAyOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M0IFdpbmRvd3MiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOkI1Q0Y2RTFBRUEwMkU1MTFCMDNGRTYzMkQyNzAwMjZBIiBzdEV2dDp3aGVuPSIyMDE1LTA1LTI1VDE2OjQzOjExKzAyOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ1M0IFdpbmRvd3MiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDw/eHBhY2tldCBlbmQ9InciPz7/7gAOQWRvYmUAZEAAAAAB/9sAhAACAgICAgICAgICAwICAgMEAwICAwQFBAQEBAQFBgUFBQUFBQYGBwcIBwcGCQkKCgkJDAwMDAwMDAwMDAwMDAwMAQMDAwUEBQkGBgkNCgkKDQ8ODg4ODw8MDAwMDA8PDAwMDAwMDwwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAAKA+gDAREAAhEBAxEB/90ABAB9/8QBogAAAAcBAQEBAQAAAAAAAAAABAUDAgYBAAcICQoLAQACAgMBAQEBAQAAAAAAAAABAAIDBAUGBwgJCgsQAAIBAwMCBAIGBwMEAgYCcwECAxEEAAUhEjFBUQYTYSJxgRQykaEHFbFCI8FS0eEzFmLwJHKC8SVDNFOSorJjc8I1RCeTo7M2F1RkdMPS4ggmgwkKGBmElEVGpLRW01UoGvLj88TU5PRldYWVpbXF1eX1ZnaGlqa2xtbm9jdHV2d3h5ent8fX5/c4SFhoeIiYqLjI2Oj4KTlJWWl5iZmpucnZ6fkqOkpaanqKmqq6ytrq+hEAAgIBAgMFBQQFBgQIAwNtAQACEQMEIRIxQQVRE2EiBnGBkTKhsfAUwdHhI0IVUmJy8TMkNEOC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');
            background-repeat: repeat-x;
        }

        #main > tr > td {
            height: 100%;
            padding: 0;
            vertical-align: middle;
        }

        #container {
            width: 100%;
            margin: 20px auto;
            text-align: left;
            padding: 10px;
        }

        @media (min-width: 768px) {
            #container {
                max-width: 730px
            }
        }

        a {
            text-decoration: none;
            color: #0AA6BA;
        }

        a:hover, a:active, a:focus {
            text-decoration: none;
            color: #098FA0;
        }

        .box {
            background: #FFF;
            border: 1px solid #ccc;
            border-radius: 0 0 1px 1px;
            position: relative;
            z-index: 100;
        }

        .top-box {
            text-align: right;
            margin-bottom: 8px;
            -webkit-transition: top .3s;
            -o-transition: top .3s;
            transition: top .3s;
            position: relative;
            top: 0;
        }

        .top-box > a, .top-box > a:hover, .top-box > a:active, .top-box > a:focus {
            color: #32608C;
            text-decoration: none;
        }

        .top-box:hover {
            top: -4px;
        }

        .top-box > .top-btn {
            padding: 12px 14px;
            background: #F0F0F0;
            border: 1px solid #ccc;
            font-size: 16px;
            -webkit-transition: all .3s;
            -o-transition: all .3s;
            transition: all .3s;
        }

        .top-box > .top-btn:hover {
            background: #E7E7E7;
        }

        .box > .title {
            padding: 30px;
            padding-bottom: 15px;
            margin: 0;
            color: #09ADC2;
        }

        .box > .title > h1 {
            padding: 0;
            margin: 0;
        }

        .box > .content {
            margin: 30px;
            margin-top: 15px;
            padding: 0;
        }

        .bottom-box > p {
            text-align: center;
            padding: 0;
            margin: 10px 0;
            color: #999;
        }

        .bottom-box > p a, .bottom-box > p a:hover, .bottom-box > p a:active, .bottom-box > p a:focus {
            color: #777;
        }

        .box > .alert {
            margin: 30px 30px 0 30px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 1px;
        }

        .alert-success {
            color: #3c763d;
            background: #dff0d8;
            border: 1px solid #d6e9c6;
        }

        .alert-danger {
            color: #a94442;
            background: #f2dede;
            border: 1px solid #ebccd1;
        }

        i.icon:before {
            content: " ";
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAMjSURBVHjaxNdLaF1VFAbgLzGtKYL1LcrWIqgDKxEFLfiiClp8YVFEkfrYRkSKFKmUHBykIFa2oAUFEUQ8KIrVgeDAgTrTQgdaBMUUW4tWjhaJpS+1JH1cJ/vKyTW5vfcmqf/kwFnr7PXvdfb619p9jUbD/4mBExksxDSAa/E8/qzK4vaBExh4CdYhYiEOznsGQkz9OB0P4VmcXTNvn1cCIaZTsRzP4YppXH6aFwIhplNwGUZwbxvXuSUQYlqAS/AY1mBBNh3BXizO/76JsTkjEGIKuBsFQs00iS1oYFntfWNOCISYzsxlNYLrWsyH8CF243Esqtn2YFfPBEJMg7gaw3hkGpe/8Sq+wkac1WLfiQM9EQgxLcUDWI0zpnHZn0/+J3g/138rfsm/oXMCIaYluBVPYWgGt91Yj3fxAa5sUwHHOiIQYjoNN+MJrGjjugPrqrL4OMT0Ju5q4/s9jrYlEGLqw01YhQdxcpsFv8baqiy+DDGN4uE2vg1sq8piZgIhpstxX9btC46TpE/zzr8LMa3C2poGTIc9+Qz8txuGmM7BnTndyzo4Gu9gfVUWP4eYrseGLDjtsBN/TSEQYjoJd+Syuu04O4DDeAUvVmXxR4jpUryMCzsg/W8F1DOwEffj3A4W2J/7+WtVWRzKWduAazosqB+zPE8hcFWHwX/FSFUW7+XMLcIzWNmFlIzVCfTn5+qs45+3+XAbhpvBMx7Fk10K2vamBkBffSYMMV2UU3lLbi5NCd2Mp6uy2FrzXYES53UR/ACGqrLYNS2BFvEZyjqwGK9XZbGjpUw3YWmXSv4DbqjKYrztUFqVxT58EWLagsGqLA7Wgp+Pl3oI3kz/ZMdTcVUWh3PJ1XViNPeEXvBtK4H+Lhe4OJdrX48ExmZLYGCGrP1Wl9d2GtDsAb0SaDS7WIu0DuPGPPlsnuHbfRhvfdlvdmgOH5/l0nob92Qyb2V7E3sxMZdXs6NZ/zdVZXEsH9ojeZfjIaZv8EJWyZX4KJOYgr5uLqchpuW5/S7EG1hTlcVEB+P6ICaqspicbQZ+x9b8HD1e8OlKeVYZmA/8MwDGXPtGWavKjQAAAABJRU5ErkJggg==');
            padding: 8px;
            font-size: 16px;
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: center;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin: 10px 0;
        }

        .table > caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: #b4bcc2;
            text-align: left;
        }

        .table > thead > tr > th, .table > tbody > tr > th {
            font-weight: bold;
            padding: 8px;
        }

        .table > thead > tr > td, .table > tbody > tr > td {
            padding: 4px 8px;
        }
        </style>
    </head>

    <body>

        <table id="main">
            <tr>
                <td>
                    <div id="container">
                        <div class="top-box">
                            <a class="top-btn" href="http://www.overcms.com" target="_blank">
                                <i class="icon"></i> &nbsp;OverCms
                            </a>
                        </div>
                        <div class="box">
                            <?php echo $_ok ? '<div class="alert alert-success">Votre hébergeur est compatible !</div>' : '<div class="alert alert-danger">Votre hébergeur n\'est pas compatible..</div>'; ?>
                            <div class="title">
                                <h1>Test de l'hébergeur</h1>
                            </div>
                            <div class="content">
                                <?php
                                    foreach ($a as $b):
                                        echo '<table class="table"><caption>'.$b[0].'</caption>';
                                        echo '<thead><tr><th style="width: 10%">#</th><th style="width: 60%">Fonctionnalité</th><th style="width: 30%">Compatible</th></tr></thead><tbody>';
                                        $i = 0;
                                        foreach($b[1] as $k => $v)
                                            echo '<tr><td>'.++$i.'</td><td>'.$k.'</td><td>'.($v==true?$y:$n).'</td></tr>';
                                        echo '</tbody></table>';
                                    endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="bottom-box">
                            <p>
                                PHP <?php echo preg_replace('/-.*$/', '', PHP_VERSION); ?>
                                -
                                <?php echo 'Exécuté en ' . (microtime(true)-$s > 1 ? number_format(microtime(true)-$s, 3) . 's' : round((microtime(true)-$s)*1000)) . 'ms'; ?>
                                -
                                Propulsé par <a href="http://www.overcms.com" target="_blank">OverCms</a></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </body>

</html>
