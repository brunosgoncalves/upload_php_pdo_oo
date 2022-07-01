<?php
    namespace App\File;
    
    class User 
    {
        private static $table = 'teste';

        public function  sqlselect(int $id)
        {
            try {
                $conn  = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME.';charset=utf8',DBUSER,DBPASS);
                $conn ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                echo 'Connection ok ';
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }


            $sql = "SELECT * FROM ". self::$table." as t where t.id = :id";
            $preparandoSql = $conn->prepare($sql);
            $preparandoSql->bindValue(':id', $id);

            $preparandoSql->execute();

            while ($row = $preparandoSql->fetchAll() ) {
                print_r($row);
            }
        }




    }
