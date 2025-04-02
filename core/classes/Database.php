<?php


namespace core\classes;

use PDO;
use PDOException;
use Exception;


class DataBase
{
        

        private $ligacao;
        
        //================================================
        private function ligar(){

            //ligar à base de dados

            $this->ligacao = new PDO(
                'mysql:'. 
                'host='.MYSQL_SERVER.';'.
                'dbname='.MYSQL_DATABASE.';'.
                'chatset='.MYSQL_CHARSET,
                MYSQL_USER,
                MYSQL_PASS,
                array(PDO::ATTR_PERSISTENT => true)
            );

            //debug

            $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        }

        //================================================

        private function desligar(){

            //desligar da base de dados

            $this->ligacao = null;
        }

        //================================================
        // CRUD
        //================================================

        public function select($sql, $parametros = null){

            //verifica se é uma instrução SELECT
            $sql = trim($sql);
            if(!preg_match("/^SELECT/i", $sql)){
                throw new Exception('Base de dados - Não é uma instrução SELELCT.');
            }
            
            //liga

            $this->ligar();

            $resultados = null;

            //comunica

            try{
                //comunicação com a base de dados
                if(!empty($parametros)){
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute($parametros);
                    $resultados = $executar->fetchAll(PDO::FETCH_CLASS);

                }else{
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute();
                    $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
                }
            }catch(PDOException $e){

                return false;
            }

            //desligar da base de dados
            $this->desligar();

            //devolver os resultados obtidos

            return $resultados;
        }  
        
         //================================================

         public function insert($sql, $parametros = null){

            //verifica se é uma instrução INSERT
            $sql = trim($sql);
            if(!preg_match("/^INSERT/i", $sql)){
                throw new Exception('Base de dados - Não é uma instrução INSERT.');
            }
            
            //Liga

            $this->ligar();


            //comunica

            try{
                //comunicação com a base de dados
                if(!empty($parametros)){
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute($parametros);
                    

                }else{
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute();
                    
                }
            }catch(PDOException $e){

                return false;
            }

            //desligar da base de dados
            $this->desligar();

            
        } 


         //================================================

         public function update($sql, $parametros = null){

            //verifica se é uma instrução UPDATE
            $sql = trim($sql);
            if(!preg_match("/^UPDATE/i", $sql)){
                throw new Exception('Base de dados - Não é uma instrução UPDATE.');
            }
            
            //Liga

            $this->ligar();


            //comunica

            try{
                //comunicação com a base de dados
                if(!empty($parametros)){
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute($parametros);
                    

                }else{
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute();
                    
                }
            }catch(PDOException $e){

                return false;
            }

            //desligar da base de dados
            $this->desligar();

            
        } 


         //================================================

         public function delete($sql, $parametros = null){

            //verifica se é uma instrução DELETE
            $sql = trim($sql);
            if(!preg_match("/^INSERT/i", $sql)){
                throw new Exception('Base de dados - Não é uma instrução DELETE.');
            }
            
            //Liga

            $this->ligar();


            //comunica

            try{
                //comunicação com a base de dados
                if(!empty($parametros)){
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute($parametros);
                    

                }else{
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute();
                    
                }
            }catch(PDOException $e){

                return false;
            }

            //desligar da base de dados
            $this->desligar();

            
        } 
    

         //================================================
         //GENÈRICA
         //================================================

         public function statement($sql, $parametros = null){

            //verifica se é uma instrução diferente das anteriores
            $sql = trim($sql);
            if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)){
                throw new Exception('Base de dados - Instrução inválida.');
            }
            
            //Liga

            $this->ligar();


            //comunica

            try{
                //comunicação com a base de dados
                if(!empty($parametros)){
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute($parametros);
                    

                }else{
                    $executar = $this->ligacao->prepare($sql);
                    $executar->execute();
                    
                }
            }catch(PDOException $e){

                return false;
            }

            //desligar da base de dados
            $this->desligar();

            
        } 

}

