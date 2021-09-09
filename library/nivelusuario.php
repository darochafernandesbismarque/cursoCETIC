<?php
error_reporting(E_ALL);

class nivelusuario extends Consulta
{

      public function insert($descricao)
    {
        $sql = 'INSERT
                    INTO
                        nivelusuario  (
                                
                                descricao
                                
                                )
                        values
                                (
                                :descricao
                                
                                )';

        $stmt = $this->getConexaoApi()->prepare($sql);

        $stmt->bindValue(':descricao', $descricao);
      
       
        try {
            $stmt->execute();

            return $this->getConexaoApi()->lastInsertId();
        } catch (PDOException $e) {

            return false;
        }
    } 
}


