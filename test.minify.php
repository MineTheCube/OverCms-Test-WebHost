<?php $c=array(array('Base de données (au moins un des deux doit fonctionner)',array('MySQL'=>@extension_loaded('pdo_mysql'),'SQLite'=>@extension_loaded('pdo_sqlite'))),array('Fonctionnalités requises',array('Version de PHP'=>version_compare(PHP_VERSION,'5.2.0','>'),'Requête HTTP'=>_crl("http://code.jquery.com/jquery-latest.min.js")||_crl("https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"),'Gestion des fichiers'=>_fls(),'Gestion des archives'=>_zip(),'Cryptage RSA'=>_rsa())),array('Fonctionnalités optionnelles',array('URL Rewrite (Apache)'=>strpos(strtolower($_SERVER["SERVER_SOFTWARE"]),'apache')!==false,'Création d\'image'=>_img(),'Ports ouverts'=>_crl("http://portquiz.net",20070),)));$d=(($c[0][1]['MySQL']or $c[0][1]['SQLite'])and!in_array(false,$c[1][1]));header('Content-Type: text/html; charset=UTF-8');$e='<img src="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGrSURBVDjLvZPZLkNhFIV75zjvYm7VGFNCqoZUJ+roKUUpjRuqp61Wq0NKDMelGGqOxBSUIBKXWtWGZxAvobr8lWjChRgSF//dv9be+9trCwAI/vIE/26gXmviW5bqnb8yUK028qZjPfoPWEj4Ku5HBspgAz941IXZeze8N1bottSo8BTZviVWrEh546EO03EXpuJOdG63otJbjBKHkEp/Ml6yNYYzpuezWL4s5VMtT8acCMQcb5XL3eJE8VgBlR7BeMGW9Z4yT9y1CeyucuhdTGDxfftaBO7G4L+zg91UocxVmCiy51NpiP3n2treUPujL8xhOjYOzZYsQWANyRYlU4Y9Br6oHd5bDh0bCpSOixJiWx71YY09J5pM/WEbzFcDmHvwwBu2wnikg+lEj4mwBe5bC5h1OUqcwpdC60dxegRmR06TyjCF9G9z+qM2uCJmuMJmaNZaUrCSIi6X+jJIBBYtW5Cge7cd7sgoHDfDaAvKQGAlRZYc6ltJlMxX03UzlaRlBdQrzSCwksLRbOpHUSb7pcsnxCCwngvM2Rm/ugUCi84fycr4l2t8Bb6iqTxSCgNIAAAAAElFTkSuQmCC" alt="Oui"/>';$f='<img src="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==" alt="Non"/>';function _crl($h,$j=0){if(!function_exists('curl_init')or!extension_loaded('curl'))return!1;$l=curl_init();curl_setopt($l,CURLOPT_HEADER,false);curl_setopt($l,CURLOPT_RETURNTRANSFER,true);curl_setopt($l,CURLOPT_TIMEOUT,10);curl_setopt($l,CURLOPT_URL,$h);if($j)curl_setopt($l,CURLOPT_PORT,$j);$m=curl_exec($l);curl_close($l);return!empty($m);}function _fls(){@unlink("test-overcms-files/data.txt");@rmdir('test-overcms-files');$q=@mkdir('test-overcms-files');if(!$q)return!1;$s=md5(time().rand(1,9999));$q=@file_put_contents('test-overcms-files/data.txt',$s);if(!$q)return!1;if(@file_get_contents('test-overcms-files/data.txt')!==$s)return!1;$q=@unlink("test-overcms-files/data.txt");if(!$q)return!1;$q=@rmdir('test-overcms-files');if(!$q)return!1;return!0;}function _zip(){$q=@file_put_contents('test-overcms-files-data.zip',base64_decode('UEsDBAoAAAAIAHUKcEaSYDpXJwAAACUAAAAIAAAAZGF0YS50eHTLL0stSs4tVqjKLFBIrShJzSvOzM9TyCxWKM8vys7MS1dIy8xLBQBQSwECCgAKAAAACAB1CnBGkmA6VycAAAAlAAAACAAAAAAAAAAAACAAAAAAAAAAZGF0YS50eHRQSwUGAAAAAAEAAQA2AAAATQAAAAAA'));if(!$q)return!1;$t=@zip_open('test-overcms-files-data.zip');if(is_resource($t)){$w=zip_read($t);$f=zip_entry_name($w);$q=zip_entry_read($w);@zip_close($t);@unlink("test-overcms-files-data.zip");if($q==='overcms zip extension is working fine' and $f==='data.txt')return!0;}@unlink("test-overcms-files-data.zip");return!1;}function _rsa(){if(!function_exists('openssl_pkey_new')or!function_exists('openssl_pkey_export')or!function_exists('openssl_sign')or!function_exists('openssl_verify')or!function_exists('mcrypt_create_iv'))return!1;$x=openssl_pkey_new(array("private_key_bits"=>2048));openssl_pkey_export($x,$z);$aa=openssl_pkey_get_details($x);$aa=$aa["key"];if(empty($aa)or empty($z))return!1;$bb=mcrypt_create_iv(10,MCRYPT_DEV_URANDOM);$cc=openssl_get_privatekey($z);openssl_sign($bb,$dd,$cc);openssl_free_key($cc);$ee=base64_encode($bb.$dd);if(empty($ee)or empty($bb))return!1;$ff=base64_decode($ee);$bb=substr($ff,0,10);$ee=substr($ff,10);$gg=openssl_get_publickey($aa);$hh=openssl_verify($bb,$ee,$gg);openssl_free_key($gg);return($hh===1);}function _img(){if(!function_exists('gd_info')or!function_exists('imagettftext'))return!1;$ii=gd_info();return $ii["PNG Support"]===true;}?><!DOCTYPE html><html lang="fr"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Compatibilité - OverCms</title><meta name="description" content="OverCms - Test de compatibilité"><link rel="icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAAAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAQAQAAAAAAAAAAAAAAAAAAAAAAAD///8BAAAAAwAAAAsAAAAXAAAAHwAAAB8AAAAfAAAAHwAAAB8AAAAfAAAAHwAAAB8AAAAXAAAACwAAAAP///8B////AQAAAAsAAAArAAAATQAAAFsAAABbAAAAWwAAAFsAAABbAAAAWwAAAFsAAABbAAAATQAAAC0AAAAL////Af///wEAAAAXDB4ofRQyQ+8VNUf/FTVH/xU1R/8VNUf/FTVH/xU1R/8VNUf/FTVH/xQzRPMMHih/AAAAF////wH///8BAAAAHxQzRO9AXoP/PVh8/0hoj/9QdaP/TG+a/z5Yef84UHH/QF2E/zdRdP86U3X/FDNE7wAAAB////8B////AQAAAB8VNUf/QF6D/0ptmP9Ue6v/TXCd/0Jii/9dZ3T/VGyM/0hrl/86VHn/MUlp/xU1R/8AAAAf////Af///wEAAAAfFTVH/z9dg/9bhLf/SGiT/0ZmkP9Sd6b/NUpn/01umv9Yf7D/Pll//0Zqlf8VNUf/AAAAH////wH///8BAAAAHxU1R/8xSWj/QF6F/zdRc/8xSGj/NExt/zZRdP9AXYT/QV+F/ztXfP9Rd6b/FTVH/wAAAB////8B////AQAAAB8VNUf/SWqU/0lsmP9EZI3/RWSM/zBIZ/84UnX/QV+F/0dmj/8+XIH/OVV4/xU1R/8AAAAf////Af///wEAAAAfFTVH/1N5q/9YeaP/U2+R/z5bgv9AXYT/UXel/zVPcP9GZpD/Unim/zxYff8VNUf/AAAAH////wH///8BAAAAHxU1R/8/Xob/S2OD/1Vrhv81UXX/OVN2/0Jhiv89WX7/RmeR/0Bgiv88WH3/FTVH/wAAAB////8B////AQAAAB8VNUf/UHSg/wyVFv89WoD/QV+F/yxCX/9txn3/MUlp/wyVFv9HUF7/PVd6/1a2Zv8AAAAf////Af///wEAAAAXI3c0/1N5qf8MlRb/OFJz/23Gff9EZIz/bcZ9/wyVFv9txn3/WmuA/23Gff8jdzT/AAAAF////wH///8BAAAACy1/Pf9Folb/bcZ9/2q4dv8pijL/DJUW/xabIv9AtVT/PbBQ/1K3Y/9isHH/Jnw4/wAAAAv///8B////AQAAAAMcVjl1Hn4t/yN3NP8jdzT/I3c0/yN3NP8jdzT/I3c0/yN3NP8jdzT/NIlD/xxWOXUAAAAD////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8BAAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//w==" type="image/x-icon"><link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css" rel="stylesheet"><style type="text/css">body{padding-top:20px;padding-bottom:20px}.footer,.header,.header{border-bottom:1px solid #e5e5e5}.header h3{padding-bottom:19px;margin-top:0;margin-bottom:0;line-height:40px}.footer{padding-top:19px;color:#777;border-top:1px solid #e5e5e5}@media (min-width:768px){.container{max-width:730px}}.container-narrow>hr{margin:30px 0}.jumbotron{text-align:center;border-bottom:1px solid #e5e5e5}.jumbotron .btn{padding:14px 24px;font-size:21px}@media screen and (min-width:768px){.footer,.header,.header{margin-bottom:30px}.jumbotron{border-bottom:0}}</style></head><body><div class="container"><div class="header"><nav><ul class="nav nav-pills pull-right"><li class="active"><a href="http://www.overcms.com/" target="_blank">OverCms</a></li></ul></nav><h3 class="text-muted">Test de compatibilité</h3></div><?php echo $d?'<div class="alert alert-success">Votre hébergeur est compatible !</div>':'<div class="alert alert-danger">Votre hébergeur n\'est pas compatible..</div>';?><?php foreach($c as $jj){echo '<table class="table"><caption>'.$jj[0].'</caption>';echo '<thead><tr><th style="width: 10%">#</th><th style="width: 50%">Fonctionnalité</th><th style="width: 40%">Compatible</th></tr></thead><tbody>';$kk=0;foreach($jj[1]as $ll=>$mm)echo '<tr><td>'.++$kk.'</td><td>'.$ll.'</td><td>'.($mm?$e:$f).'</td></tr>';echo '</tbody></table>';}?></div></body></html>