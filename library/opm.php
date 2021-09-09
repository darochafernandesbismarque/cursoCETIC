<?php
error_reporting(E_ALL);

class opm extends Consulta
{
     /*

       public function insert($cod_opm, $cod_opm_novo, $abrev_opm, $is_odonto, $abrev_opm_novo, $desc_opm, $NOMETABELA, $ENDERECO, $vinculacao, $cod_vinculacao,
       $flag_opm, $ordem, $opm_chave, $organograma, $opm_sediada_qg)
    {
        $sql = 'INSERT
                    INTO
                        opm  (
                            cod_opm, 
                            cod_opm_novo,
                            abrev_opm,
                            is_odonto, 
                            abrev_opm_novo, 
                            desc_opm, 
                            NOMETABELA,
                            ENDERECO, 
                            vinculacao, 
                            cod_vinculacao,
                            flag_opm, 
                            ordem,
                            opm_chave, 
                            organograma, 
                            opm_sediada_qg
                                
                                )
                        values
                                (
                            :cod_opm, 
                            :cod_opm_novo,
                            :abrev_opm,
                            :is_odonto, 
                            :abrev_opm_novo, 
                            :desc_opm, 
                            :NOMETABELA,
                            :ENDERECO, 
                            :vinculacao, 
                            :cod_vinculacao,
                            :flag_opm, 
                            :ordem,
                            :opm_chave, 
                            :organograma, 
                            :opm_sediada_qg
                                )';

        $stmt = $this->getConexaoApi()->prepare($sql);

        $stmt->bindValue(':cod_opm', $cod_opm);
        $stmt->bindValue(':cod_opm_novo', $cod_opm_novo);
        $stmt->bindValue(':abrev_opm', $abrev_opm);
        $stmt->bindValue(':is_odonto', $is_odonto);
        $stmt->bindValue(':abrev_opm_novo', $abrev_opm_novo);
        $stmt->bindValue(':desc_opm', $desc_opm);
        $stmt->bindValue(':NOMETABELA', $NOMETABELA);
        $stmt->bindValue(':ENDERECO', $ENDERECO);
        $stmt->bindValue(':vinculacao', $vinculacao);
        $stmt->bindValue(':cod_vinculacao', $cod_vinculacao);
        $stmt->bindValue(':flag_opm', $flag_opm);
        $stmt->bindValue(':ordem', $ordem);
        $stmt->bindValue(':opm_chave', $opm_chave);
        $stmt->bindValue(':organograma', $organograma);
        $stmt->bindValue(':opm_sediada_qg', $opm_sediada_qg);
        
       

        try {
            $stmt->execute();

            return $this->getConexaoApi()->lastInsertId();
        } catch (PDOException $e) {

            return false;
        }
    } 

    */
}


