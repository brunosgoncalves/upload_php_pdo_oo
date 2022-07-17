<?php
    namespace App\File;
    
    class User 
    {
        private static $table = TABELABANCO;

        public function conctaBanco()
        {
            try {
                $conn  = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME.';charset=utf8',DBUSER,DBPASS);
                $conn ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (\PDOException $e) {
                echo 'Connection failed: '.$e->getMessage();
            }
        }

        public function  sqlselect(int $id)
        {
            
            $sql = "SELECT * FROM ". self::$table." as t where t.nnf = :id";
            $preparandoSql = $this->conctaBanco()->prepare($sql);
            $preparandoSql->bindValue(':id', $id);

            $preparandoSql->execute();

            while ($row = $preparandoSql->fetchAll() ) {
                print_r($row);
            }
        }

        public function  sqlInsertCli($dados)
        {
            
            $sql = "inser into  ". self::$table." values(:nnf, :dh_emi, :cnpj, :x_nome, :ender_dest, :xlgr, :nro, :xbairro, :cmun, :uf, :cep, :cpais, :fone, :vnf);";
            $preparandoSql = $this->conctaBanco()->prepare($sql);
            $preparandoSql->bindValue(':nnf', $dados['nnf']);
            $preparandoSql->bindValue(':dh_emi', $dados['dh_emi']);
            $preparandoSql->bindValue(':cnpj', $dados['cnpj']);
            $preparandoSql->bindValue(':x_nome', $dados['x_nome']);
            $preparandoSql->bindValue(':ender_dest', $dados['ender_dest']);
            $preparandoSql->bindValue(':xlgr', $dados['xlgr']);
            $preparandoSql->bindValue(':nro', $dados['nro']);
            $preparandoSql->bindValue(':xbairro', $dados['xbairro']);
            $preparandoSql->bindValue(':cmun', $dados['cmun']);
            $preparandoSql->bindValue(':uf', $dados['uf']);
            $preparandoSql->bindValue(':cep', $dados['cep']);
            $preparandoSql->bindValue(':cpais', $dados['cpais']);
            $preparandoSql->bindValue(':fone', $dados['fone']);
            $preparandoSql->bindValue(':vnf', $dados['vnf']);

            $preparandoSql->execute();
            echo "<pre>";
            print_r($dados);
            exit();

        }



    }
