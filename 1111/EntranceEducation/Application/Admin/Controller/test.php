<?php
if(@fopen($url,'r')){   
    echo 'File Exits';
}else{    
    echo 'File Do Not Exits';
}