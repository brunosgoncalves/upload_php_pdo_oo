<?php

namespace App\File;

use SimpleXMLElement;

class Upload{

    /**
     * Nome do arquivo a ser postado
     * @var string
     */
    private $name;

    /**
     * Extension do arquivo
     * @var string
     */
    private $extension;

    /**
     * Tipo do arquivo
     * @var string
     */
    private $type;

     /**
     * Nome do arquivo temporario.
     * @var string
     */
    private $tmpName;


    /**
     * erro no import do arquivo
     * @var string
     */
    private $error;

    /**
     * Tamanho do arquivo
     * @var string
     */
    private $size;

    /**
     * Contrutor
     * @param array $arquivos  $_FILES[dados] 
     */

    public function __construct($arquivos)
    {
        $arq  = pathinfo($arquivos['name']);
        $this->extension = $arq['extension'];
        $this->name = $arq['filename'];
        $this->error = $arquivos['error'];
        $this->size = $arquivos['size'];
        $this->tmpName = $arquivos['tmp_name'];
        $this->type = $arquivos['type'];
                 
    }

    public function caminhoArquivo()
    {
        $extension = strlen($this->extension)?'.'.$this->extension : '';
        return $this->name.$extension;
    }

    public function upload($localArquivo,$tipoArquivo)
    {
        if (in_array($this->extension, $tipoArquivo) and $this->error == 0) { 
            $path = $localArquivo.'\\'.$this->caminhoArquivo();

            $this->entraArquivo($this->tmpName,CPFCLIENTE);
           // return move_uploaded_file($this->tmpName, $path);  
        }else{
            return false;
        }

        return $teste = $this->error ==0 ? false:true;
  
    }

    public function entraArquivo($path,$cpfTem)
    {
        $file  = simplexml_load_file($path);
        
        $teste  = $file->asXML();
        $file = json_decode(json_encode($file),TRUE);

        if(strpos($teste, $cpfTem)){
            
            $last_names = array_column($file, 'nProt');
            print_r($last_names);


            // if(array_column( $file['protNFe']['infProt'], "nProt")){
            //     echo "<pre>";
            //     print_r($file['protNFe']['infProt']);
            //     exit();
            // }


            
        }
        else {
echo "não";
        }


        echo "<pre>-------------------------------------";
        print_r($teste);
        exit();

        // Instância o objeto SimpleXMLElement passando como parâmetro o XML
        $xml = new SimpleXMLElement($path);
        
        // Retorna os Namespaces existentes no XML
        $ns = $xml->getNamespaces(true);
        
        print_r($ns);
        exit();


        // Retorna todos os elementos filhos com Namespace 'p'
        $child = $xml->children($ns['p']);
        
        // Percorre os elementos filhos
        foreach ($child->cliente as $elemento):
            echo $elemento . '<br>';
        endforeach;
                
        //$file = fopen($path, "r");

        // //Output lines until EOF is reached
        // while(! feof($file)) {
        // $line = fgets($file);
        // echo "<br>*---- ".$line. "---<br>";
        // }

        // $contents=file_get_contents($path);
        // $lines=explode("\n",$contents);
        // foreach($lines as $line){
        
        // $xml = simplexml_load_file($line) -> channel;

        // echo $xml.'<br>';
        // }

        
    }

    public function uploadErroTipo($erro)
    {
       
        switch ($erro) {
            case 1:
                $message = "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini";
                break;
            case 2:
                $message = "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML";
                break;
            case 3:
                $message = "O upload do arquivo foi feito parcialmente";
                break;
            case 4:
                $message = "Nenhum arquivo foi enviado";
                break;
            case 6:
                $message = "Pasta temporária ausente";
                break;
            case 7:
                $message = " Falha ao escrever o arquivo no disco";
                break;
            case 8:
                $message = "Uma extensão do PHP interrompeu o upload do arquivo. O PHP não fornece uma maneira de determinar qual extensão causou a interrupção do upload. Examinar a lista das extensões carregadas com o phpinfo() pode ajudar.";
                break;

            default:
                $message = "o upload foi bem sucedido";
                break;
        }
        return $message;
    }






}
