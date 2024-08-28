<?php
function CurrentPageURL()
{
$pageURL = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
$pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
return $pageURL;
}

$ur = basename($_SERVER['REQUEST_URI'], ""); 
$uri = substr($_SERVER['REQUEST_URI'], 1); 
$websitendir = urldecode(str_replace($ur, "", CurrentPageURL()));
$pagedir = urldecode(str_replace($ur, "", $uri));
$path_parts = pathinfo('./'.$pagedir.$ur); 
$nameWE = $path_parts['filename']; 

$stack = array (); 

if ($handle = opendir('./'.$pagedir)) { 
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != "..") {
            array_push ($stack,$file); 
        }
    }
    closedir($handle);
}


$stackNE = array (); 
if ($handle = opendir('./'.$pagedir)) { 
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != "..") {
		;
$tfile = explode(".", $file);
$nu = count($tfile);
$nu = 2-$nu;
array_push ($stackNE,$tfile[$nu]); 
        }
    }
    closedir($handle);
}
$stackNE = array_filter($stackNE);

$stack2 = explode(',',strtoupper(join(',',$stack))); 
$index = array_search(strtoupper($ur), $stack2); 
$link = $websitendir.$stack[$index]; 

if($index){ 
header('Location: '.$link.'');
}else{
$newr = array ();
foreach($stack2 as $key1=>$value1) {
  if(strpos($value1, strtoupper($ur))) {
  array_push ($newr,$value1);
  }
}
if($newr){ 
$nlink = $websitendir.$newr[0]; 
header('Location: '.$nlink.'');
}else{
$newr2 = array (); 
$newextentions = array(1 => $nameWE.'.html',$nameWE.'.htm',$nameWE.'.gif',$nameWE.'.jpg',$nameWE.'.png',$nameWE.'.cgi',$nameWE.'.pl',$nameWE.'.js',$nameWE.'.java',$nameWE.'.class',$nameWE.'.asp',$nameWE.'.cfm',$nameWE.'.cfml',$nameWE.'.shtm',$nameWE.'.shml',$nameWE.'.php',$nameWE.'.php3');
foreach($newextentions as $key=>$value) {
if (file_exists( './'.$pagedir.$value)) {
  array_push ($newr2,$value);
}
}

if($newr2){
$nlink2 = $websitendir.$newr2[0]; 
header('Location: '.$nlink2.'');
}else{

echo "<h3>404 File Not Found</h1>Sorry, the file you were looking for could not be found. It may have moved to a new location or could of just been temporary, or even *gulp* deleted.<br>
To go on to the main page of this site, click the link below:<br>
<a href = '/'>https://zepeto.club/</a>";
}
}
}
?>
