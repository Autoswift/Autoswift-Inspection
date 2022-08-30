<?php    
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";   
    $filename = $PNG_TEMP_DIR.'test4.png';
    QRcode::png('https://www.arvindampro.in/uploads/finance/pdf/1593783996.pdf', $filename,'H',2,2);            
	echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';  
    

    