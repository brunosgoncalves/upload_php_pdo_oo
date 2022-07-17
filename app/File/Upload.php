<?php

namespace App\File;

use \App\File\User;


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
        $this->useBancoMysql =  new User();
        
                 
    }

    public function caminhoArquivo()
    {
        $extension = strlen($this->extension)?'.'.$this->extension : '';
        return $this->name.$extension;
    }

    public function upload($localArquivo,$tipoArquivo,$cnpjAValidar)
    {
        
        if (in_array($this->extension, $tipoArquivo) and $this->error == 0) { 
            
            $path = $localArquivo.'\\'.$this->caminhoArquivo();
            $retornoTesteAquivo = $this->entraArquivo($this->tmpName, $cnpjAValidar);
            if($retornoTesteAquivo == true){
                
                move_uploaded_file($this->tmpName, $path); 
                return  true;
            }else{
                return $retornoTesteAquivo;
            }
        }else{
            return "Aextencao do arquivo esta com problemas!!!";
        }
    }

    public function entraArquivo($path,$cpfTem)
    {
        $file  = simplexml_load_file($path);
        
        $teste  = $file->asXML();
        $file = json_decode(json_encode($file),TRUE);
        
        if(strpos($teste, $cpfTem)){
            if (array_key_exists('nProt', $file['protNFe']['infProt'])) {
                if(!empty($file['protNFe']['infProt']['nProt'])){
                    $this->useBancoMysql->sqlInsertCli($this->tratamentoUpload($file));
                    return true;
                }else{
                    echo 'Value nProt não existente.';
                }
            } else {
                echo 'nProt não existente.';
            }
        }else{
            echo 'Cnpj não existente.';
        }
    }

    public function tratamentoUpload($jsonDados)
    {   
        $dados = [
            'nnf'=>  $jsonDados['NFe']['infNFe']['ide']['nNF'],
            'dh_emi'=>  $jsonDados['NFe']['infNFe']['ide']['dhEmi'],
            'cnpj'=>  $jsonDados['NFe']['infNFe']['dest']['CNPJ'],
            'x_nome'=>  $jsonDados['NFe']['infNFe']['dest']['CNPJ'],
            'ender_dest'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['xFant'],
            'xlgr'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['xLgr'],
            'nro'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['nro'],
            'xbairro'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['xBairro'],
            'cmun'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['cMun'],
            'uf'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['xMun'],
            'cep'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['UF'],
            'cpais'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['CEP'],
            'fone'=>  $jsonDados['NFe']['infNFe']['dest']['enderDest']['cPais'],
            'vnf'=>  $jsonDados['NFe']['infNFe']['total']['ICMSTot']['vNF']
        ];

        return $dados;
    }

    






}
