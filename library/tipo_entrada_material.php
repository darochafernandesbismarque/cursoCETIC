<?php
error_reporting(E_ALL);

include_once 'Consulta.php';
include_once 'Conexao.php';

class tipoentradamaterial extends Consulta
{
    public static function inserir($tipoentrada, $fornecedor, $datadocumento, $tipodocumento, $valortotal, $dataentrada, $id_usb)
    {
        $conexao = Conexao::conectar();

        $cmd = $conexao->prepare("INSERT INTO entradamaterial SET valortotal = :valortotal, datadocumento = :datadocumento, dataentrada = :dataentrada,
                                  id_fornecedor = :fornecedor, id_tipoentrada = :tipoentrada, id_tipodocumento = :tipodocumento, id_usb = :id_usb");

		$cmd->bindValue(":tipoentrada", $tipoentrada);
        $cmd->bindValue(":fornecedor", $fornecedor);
        $cmd->bindValue(":datadocumento", $datadocumento);
        $cmd->bindValue(":tipodocumento", $tipodocumento);
        $cmd->bindValue(":valortotal", $valortotal);
        $cmd->bindValue(":dataentrada", $dataentrada);
        $cmd->bindValue(":id_usb", $id_usb);
		$cmd->execute();
    }
}
