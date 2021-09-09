<?php
error_reporting(E_ALL);

class pedido extends Consulta
{

       public function insert($pedido, $id_material, $ult_estoque, $qnt_saida, $id_entrada, $valor_individual, $val_total, $user_saida, $data_pedidos, $destino,
       $tipo_doc, $documento, $dt_doc, $status, $id_opm, $obs)
    {
        $sql = 'INSERT
                    INTO
                        pedido  (
                            pedido, 
                            id_material, 
                            ult_estoque,
                            qnt_saida, 
                            id_entrada, 
                            valor_individual, 
                            val_total, 
                            user_saida, 
                            data_pedidos, 
                            destino,
                            tipo_doc, 
                            documento, 
                            dt_doc, 
                            status, 
                            id_opm, 
                            obs
                                
                                )
                        values
                                (
                            :pedido, 
                            :id_material, 
                            :ult_estoque,
                            :qnt_saida, 
                            :id_entrada, 
                            :valor_individual, 
                            :val_total, 
                            :user_saida, 
                            :data_pedidos, 
                            :destino,
                            :tipo_doc, 
                            :documento, 
                            :dt_doc, 
                            :status, 
                            :id_opm, 
                            :obs
                                )';

        $stmt = $this->getConexaoApi()->prepare($sql);

        $stmt->bindValue(':pedido', $pedido);
        $stmt->bindValue(':id_material', $id_material);
        $stmt->bindValue(':ult_estoque', $ult_estoque);
        $stmt->bindValue(':qnt_saida', $qnt_saida);
        $stmt->bindValue(':id_entrada', $id_entrada);
        $stmt->bindValue(':valor_individual', $valor_individual);
        $stmt->bindValue(':val_total', $val_total);
        $stmt->bindValue(':user_saida', $user_saida);
        $stmt->bindValue(':data_pedidos', $data_pedidos);
        $stmt->bindValue(':destino', $destino);
        $stmt->bindValue(':tipo_doc', $tipo_doc);
        $stmt->bindValue(':documento', $documento);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id_opm', $id_opm);
        $stmt->bindValue(':obs', $obs);
        
        
       

        try {
            $stmt->execute();

            return $this->getConexaoApi()->lastInsertId();
        } catch (PDOException $e) {

            return false;
        }
    } 
}


