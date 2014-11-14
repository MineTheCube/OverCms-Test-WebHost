<?php

$y = '<img src="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGrSURBVDjLvZPZLkNhFIV75zjvYm7VGFNCqoZUJ+roKUUpjRuqp61Wq0NKDMelGGqOxBSUIBKXWtWGZxAvobr8lWjChRgSF//dv9be+9trCwAI/vIE/26gXmviW5bqnb8yUK028qZjPfoPWEj4Ku5HBspgAz941IXZeze8N1bottSo8BTZviVWrEh546EO03EXpuJOdG63otJbjBKHkEp/Ml6yNYYzpuezWL4s5VMtT8acCMQcb5XL3eJE8VgBlR7BeMGW9Z4yT9y1CeyucuhdTGDxfftaBO7G4L+zg91UocxVmCiy51NpiP3n2treUPujL8xhOjYOzZYsQWANyRYlU4Y9Br6oHd5bDh0bCpSOixJiWx71YY09J5pM/WEbzFcDmHvwwBu2wnikg+lEj4mwBe5bC5h1OUqcwpdC60dxegRmR06TyjCF9G9z+qM2uCJmuMJmaNZaUrCSIi6X+jJIBBYtW5Cge7cd7sgoHDfDaAvKQGAlRZYc6ltJlMxX03UzlaRlBdQrzSCwksLRbOpHUSb7pcsnxCCwngvM2Rm/ugUCi84fycr4l2t8Bb6iqTxSCgNIAAAAAElFTkSuQmCC" alt="Oui"/>';
$n = '<img src="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==" alt="Non"/>';

function _r($x) {
    if ($x) echo '<div class="alert alert-success">Hébergeur compatible !</div>';
    else echo '<div class="alert alert-danger">Hébergeur incompatible..</div>';
    return;
}

/////////////////////////////////////////////////////////////////////

function _table($id) {
    global $a, $y, $n;
    echo '<thead><tr><th style="width: 10%">#</th><th style="width: 50%">Fonctionnalité</th><th style="width: 40%">Compatible</th></tr></thead><tbody>';
    $i = 0;
    foreach($a[$id] as $k => $v) {
        $i++;
        echo '<tr><td>'.$i.'</td><td>'.$k.'</td><td>'.($v==true?$y:$n).'</td></tr>';
    }
    echo '</tbody>';
}

/////////////////////////////////////////////////////////////////////

function _curl() {
    if (!function_exists('curl_init')) return false;
    if (!in_array('curl',get_loaded_extensions())) return false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://code.jquery.com/jquery-latest.min.js");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);
    return !empty($output);
}

function _files() {
	@unlink("test-overcms-files/data.txt");
	@rmdir('test-overcms-files');
	$r = @mkdir('test-overcms-files');
	if (!$r) return false;
	$r = @file_put_contents('test-overcms-files/data.txt', 'abc');
	if (!$r) return false;
	if (file_get_contents('test-overcms-files/data.txt') != 'abc') return false;
	$r = @unlink("test-overcms-files/data.txt");
	if (!$r) return false;
	$r = @rmdir('test-overcms-files');
	if (!$r) return false;
	return true;
}

function _zip() {
    $r = @file_put_contents('test-overcms-files-data.zip', base64_decode('UEsDBAoAAAAAAGGNbkWNTPz9BAAAAAQAAAAIAAAAZGF0YS50eHR0cnVlUEsBAgoACgAAAAAAYY1uRY1M/P0EAAAABAAAAAgAAAAAAAAAAAAgAAAAAAAAAGRhdGEudHh0UEsFBgAAAAABAAEANgAAACoAAAAAAA=='));
    if (!$r) return false;
    $zip = @zip_open('test-overcms-files-data.zip');
    if (is_resource($zip)) {
        $zip_entry = zip_read($zip);
        $r = zip_entry_read($zip_entry);
        @zip_close($zip);
        @unlink("test-overcms-files-data.zip");
        if ($r === "true") return true;
    }
    @unlink("test-overcms-files-data.zip");
    return false;
}

function _image() {
    if (function_exists('gd_info') and function_exists('imagettftext')) {
        $g = gd_info();
        return $g["PNG Support"] == true;
    }
    return false;
}

/////////////////////////////////////////////////////////////////////

$a = array(
    1 => array(
        'MySQL' => @extension_loaded('pdo_mysql'),
        'SQLite' => @extension_loaded('pdo_sqlite'),
    ),
    2 => array(
        'Version de PHP' => version_compare(PHP_VERSION, '5.2.0', '>'),
        'Extension cURL' => _curl(),
        'Gestion des fichiers' => _files(),
        'Gestion des archives' => _zip(),
    ),
    3 => array(
        'URL Rewrite (Apache)' => strpos(strtolower($_SERVER["SERVER_SOFTWARE"]), 'apache') !== false,
        'Création d\'image' => _image(),
    )
);

$install = (($a[1]['MySQL'] or $a[1]['SQLite']) and !in_array(false, $a[2]));

header('Content-Type: text/html; charset=UTF-8');

?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compatibilité - OverCms</title>
    <link rel="icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAAAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAQAQAAAAAAAAAAAAAAAAAAAAAAAD///8BAAAAAwAAAAsAAAAXAAAAHwAAAB8AAAAfAAAAHwAAAB8AAAAfAAAAHwAAAB8AAAAXAAAACwAAAAP///8B////AQAAAAsAAAArAAAATQAAAFsAAABbAAAAWwAAAFsAAABbAAAAWwAAAFsAAABbAAAATQAAAC0AAAAL////Af///wEAAAAXDB4ofRQyQ+8VNUf/FTVH/xU1R/8VNUf/FTVH/xU1R/8VNUf/FTVH/xQzRPMMHih/AAAAF////wH///8BAAAAHxQzRO9AXoP/PVh8/0hoj/9QdaP/TG+a/z5Yef84UHH/QF2E/zdRdP86U3X/FDNE7wAAAB////8B////AQAAAB8VNUf/QF6D/0ptmP9Ue6v/TXCd/0Jii/9dZ3T/VGyM/0hrl/86VHn/MUlp/xU1R/8AAAAf////Af///wEAAAAfFTVH/z9dg/9bhLf/SGiT/0ZmkP9Sd6b/NUpn/01umv9Yf7D/Pll//0Zqlf8VNUf/AAAAH////wH///8BAAAAHxU1R/8xSWj/QF6F/zdRc/8xSGj/NExt/zZRdP9AXYT/QV+F/ztXfP9Rd6b/FTVH/wAAAB////8B////AQAAAB8VNUf/SWqU/0lsmP9EZI3/RWSM/zBIZ/84UnX/QV+F/0dmj/8+XIH/OVV4/xU1R/8AAAAf////Af///wEAAAAfFTVH/1N5q/9YeaP/U2+R/z5bgv9AXYT/UXel/zVPcP9GZpD/Unim/zxYff8VNUf/AAAAH////wH///8BAAAAHxU1R/8/Xob/S2OD/1Vrhv81UXX/OVN2/0Jhiv89WX7/RmeR/0Bgiv88WH3/FTVH/wAAAB////8B////AQAAAB8VNUf/UHSg/wyVFv89WoD/QV+F/yxCX/9txn3/MUlp/wyVFv9HUF7/PVd6/1a2Zv8AAAAf////Af///wEAAAAXI3c0/1N5qf8MlRb/OFJz/23Gff9EZIz/bcZ9/wyVFv9txn3/WmuA/23Gff8jdzT/AAAAF////wH///8BAAAACy1/Pf9Folb/bcZ9/2q4dv8pijL/DJUW/xabIv9AtVT/PbBQ/1K3Y/9isHH/Jnw4/wAAAAv///8B////AQAAAAMcVjl1Hn4t/yN3NP8jdzT/I3c0/yN3NP8jdzT/I3c0/yN3NP8jdzT/NIlD/xxWOXUAAAAD////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8BAAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//w==" type="image/x-icon">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">body{padding-top:20px;padding-bottom:20px}.footer,.header,.marketing{padding-right:15px;padding-left:15px}.header{border-bottom:1px solid #e5e5e5}.header h3{padding-bottom:19px;margin-top:0;margin-bottom:0;line-height:40px}.footer{padding-top:19px;color:#777;border-top:1px solid #e5e5e5}@media (min-width:768px){.container{max-width:730px}}.container-narrow>hr{margin:30px 0}.jumbotron{text-align:center;border-bottom:1px solid #e5e5e5}.jumbotron .btn{padding:14px 24px;font-size:21px}.marketing{margin:40px 0}.marketing p+h4{margin-top:28px}@media screen and (min-width:768px){.footer,.header,.marketing{padding-right:0;padding-left:0}.header{margin-bottom:30px}.jumbotron{border-bottom:0}}</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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

    <?php _r($install); ?>

  <table class="table">
      <caption>Base de données (nécessite au moins 1 compatible)</caption>
      <?php _table(1); ?>
    </table>

  <table class="table">
      <caption>Fonctionnalités requises</caption>
      <?php _table(2); ?>
    </table>

  <table class="table">
      <caption>Fonctionnalités optionnelles</caption>
      <?php _table(3); ?>
    </table>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

  </body>
</html>
