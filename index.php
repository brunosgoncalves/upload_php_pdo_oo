<?php 

require __DIR__.'/vendor/autoload.php';

use \App\File\Upload;
use \App\File\User;

$tipos = ['xml'];
// $sqlUser = new User();

// $sqlUser->sqlselect(1);

// exit();


if(isset($_FILES['arquivo'])){
    $ojtUplosd = new UpLoad($_FILES['arquivo']);

    $testeErro = $ojtUplosd->upload(__DIR__.'\File',$tipos);

    if($testeErro){
        echo 'Arquivo Importado';
        exit();
    }
    die('Probloma a enviar o arquivo!!!');
}

include __DIR__.'/includes/formulario.php';




