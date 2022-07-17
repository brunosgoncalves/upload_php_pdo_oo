<?php 

require __DIR__.'/vendor/autoload.php';

use \App\File\Upload;


if(isset($_FILES['arquivo'])){
    $ojtUplosd = new UpLoad($_FILES['arquivo']);

    $testeErro = $ojtUplosd->upload(__DIR__.'\File',TIPOEXTENCAO, CPFCLIENTE);

    if($testeErro){
        echo 'Arquivo Importado';
        
        exit();
    }
    die('Probloma a enviar o arquivo!!!');
}

include __DIR__.'/includes/formulario.php';




