<?php

header('Content-Type: text/html; charset=UTF-8');
$s = microtime(true);

function_exists('error_reporting') && error_reporting(0);
function_exists('ini_set') && ini_set("display_errors", 0);

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
        'Encryptage' => _rsa() && _mbc()
    )), array(
        'Fonctionnalités optionnelles', array(
        'URL Rewrite (Apache)' => strpos(strtolower($_SERVER["SERVER_SOFTWARE"]), 'apache') !== false,
        'Création d\'image' => _img(),
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

function is_disabled($l) {
    foreach (explode(' ', $l) as $f)
        if (!function_exists($f)) return true;
    return false;
}

function _crl($u, $p = 0) {
    if (is_disabled('curl_init') || !extension_loaded('curl')) return false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_URL, $u);
    if ($p) curl_setopt($ch, CURLOPT_PORT, $p);
    $o = curl_exec($ch);
    curl_close($ch);
    return !empty($o);
}

function _adv() {
    if (is_disabled('ini_get ini_set error_reporting move_uploaded_file')) return false;
    if (ini_get('safe_mode')) return false;
    $d = ini_get('session.name');
    if (empty($d)) return false;
    $r = ini_set('session.name', 'PHP_SESSION_CUSTOM');
    if ($r === false || ini_get('session.name') !== 'PHP_SESSION_CUSTOM') return false;
    $r = ini_set('session.name', $d);
    return is_string($r);
}

function _fls() {
    if (is_disabled('ini_get ini_set error_reporting move_uploaded_file')) return false;
    if (is_file('test-overcms-files/data.txt'))
        unlink("test-overcms-files/data.txt");
    if (is_dir('test-overcms-files'))
        rmdir('test-overcms-files');
    $r = mkdir('test-overcms-files') && chmod('test-overcms-files', 0755);
    if (!$r) return false;
    $rd = md5(time().rand(1,9999));
    $r = file_put_contents('test-overcms-files/new-file.txt', $rd) && chmod('test-overcms-files/new-file.txt', 0755);
    if (!$r) return false;
    $r = rename('test-overcms-files/new-file.txt', 'test-overcms-files/data.txt');
    if (!$r) return false;
    $fp = fopen('test-overcms-files/data.txt', 'rw');
    if (!is_resource($fp)) return false;
    if (fread($fp, 1024) !== $rd) return false;
    $r = unlink("test-overcms-files/data.txt");
    if (!$r) return false;
    $r = rmdir('test-overcms-files');
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
        $a = ($r === 'overcms zip extension is working fine' && $n === 'data.txt');
    }
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
    if (is_disabled('gd_info imagettftext')) return false;
    $g = gd_info();
    return $g["PNG Support"] === true;
}

/////////////////////////////////////////////////////////////////////

?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compatibilité - OverCms</title>
    <meta name="description" content="OverCms - Test de compatibilité">
    <link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAMjSURBVHjaxNdLaF1VFAbgLzGtKYL1LcrWIqgDKxEFLfiiClp8YVFEkfrYRkSKFKmUHBykIFa2oAUFEUQ8KIrVgeDAgTrTQgdaBMUUW4tWjhaJpS+1JH1cJ/vKyTW5vfcmqf/kwFnr7PXvdfb619p9jUbD/4mBExksxDSAa/E8/qzK4vaBExh4CdYhYiEOznsGQkz9OB0P4VmcXTNvn1cCIaZTsRzP4YppXH6aFwIhplNwGUZwbxvXuSUQYlqAS/AY1mBBNh3BXizO/76JsTkjEGIKuBsFQs00iS1oYFntfWNOCISYzsxlNYLrWsyH8CF243Esqtn2YFfPBEJMg7gaw3hkGpe/8Sq+wkac1WLfiQM9EQgxLcUDWI0zpnHZn0/+J3g/138rfsm/oXMCIaYluBVPYWgGt91Yj3fxAa5sUwHHOiIQYjoNN+MJrGjjugPrqrL4OMT0Ju5q4/s9jrYlEGLqw01YhQdxcpsFv8baqiy+DDGN4uE2vg1sq8piZgIhpstxX9btC46TpE/zzr8LMa3C2poGTIc9+Qz8txuGmM7BnTndyzo4Gu9gfVUWP4eYrseGLDjtsBN/TSEQYjoJd+Syuu04O4DDeAUvVmXxR4jpUryMCzsg/W8F1DOwEffj3A4W2J/7+WtVWRzKWduAazosqB+zPE8hcFWHwX/FSFUW7+XMLcIzWNmFlIzVCfTn5+qs45+3+XAbhpvBMx7Fk10K2vamBkBffSYMMV2UU3lLbi5NCd2Mp6uy2FrzXYES53UR/ACGqrLYNS2BFvEZyjqwGK9XZbGjpUw3YWmXSv4DbqjKYrztUFqVxT58EWLagsGqLA7Wgp+Pl3oI3kz/ZMdTcVUWh3PJ1XViNPeEXvBtK4H+Lhe4OJdrX48ExmZLYGCGrP1Wl9d2GtDsAb0SaDS7WIu0DuPGPPlsnuHbfRhvfdlvdmgOH5/l0nob92Qyb2V7E3sxMZdXs6NZ/zdVZXEsH9ojeZfjIaZv8EJWyZX4KJOYgr5uLqchpuW5/S7EG1hTlcVEB+P6ICaqspicbQZ+x9b8HD1e8OlKeVYZmA/8MwDGXPtGWavKjQAAAABJRU5ErkJggg==">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">body{padding-top:20px;padding-bottom:20px}.footer,.header,.header{border-bottom:1px solid #e5e5e5}.header h3{padding-bottom:19px;margin-top:0;margin-bottom:0;line-height:40px}.footer{padding-top:19px;color:#777;border-top:1px solid #e5e5e5}@media (min-width:768px){.container{max-width:730px}}.container-narrow>hr{margin:30px 0}.jumbotron{text-align:center;border-bottom:1px solid #e5e5e5}.jumbotron .btn{padding:14px 24px;font-size:21px}@media screen and (min-width:768px){.footer,.header,.header{margin-bottom:30px}.jumbotron{border-bottom:0}}</style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li class="active"><a href="http://www.overcms.com/" target="_blank">OverCms</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Test de compatibilité</h3>
      </div>
        <?php 
            echo $_ok ? '<div class="alert alert-success">Votre hébergeur est compatible !</div>' : '<div class="alert alert-danger">Votre hébergeur n\'est pas compatible..</div>';
            
            foreach ($a as $b):
                echo '<table class="table"><caption>'.$b[0].'</caption>';
                echo '<thead><tr><th style="width: 10%">#</th><th style="width: 50%">Fonctionnalité</th><th style="width: 40%">Compatible</th></tr></thead><tbody>';
                $i = 0;
                foreach($b[1] as $k => $v)
                    echo '<tr><td>'.++$i.'</td><td>'.$k.'</td><td>'.($v==true?$y:$n).'</td></tr>';
                echo '</tbody></table>';
            endforeach;
        ?>
      <p class="text-muted text-center">
        <?php
            echo 'PHP version ' .substr(PHP_VERSION, 0, strpos(PHP_VERSION, '-')). ' - Exécuté en ';
            $time = microtime(true)-$s;
            echo $time > 1 ? number_format($time, 3) . 's' : round($time*1000) . 'ms';
        ?>
      </p>
    </div>
  </body>
</html>