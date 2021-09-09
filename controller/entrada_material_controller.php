<?php
if (isset($_REQUEST['enviar'])) {

    $id_fornecedor = $_REQUEST['fornecedor'];
    $id_material   = $_REQUEST['material'];
    $qnt           = $_REQUEST['qnt'];
    $qnt_atual     = $_REQUEST['qnt_atual'];
    $vl_uni        = $_REQUEST['vl_uni'];
    $nf            = $_REQUEST['nf'];
    $tipo_verba    = $_REQUEST['tipoverba'];
    $documento     = $_REQUEST['documento'];
    $und_medida    = $_REQUEST['unidadeMedida'];
    $id_opm        = $_REQUEST['id_opm'];
    $status        = $_REQUEST['status'];
    $validade      = $_REQUEST['validade'];
    $dt_doc        = $_REQUEST['dtdoc'];
    $obs           = $_REQUEST['obs'];
    $contrato      = $_REQUEST['contrato'];
    $empenho       = $_REQUEST['empenho'];
    $ata           = $_REQUEST['ata'];
    $processo      = $_REQUEST['processo'];

    echo "<span style='color:red';> id fornecedor - </span>" . $id_fornecedor . "<br>";
    echo "<span style='color:red';>id id_material - </span>" . $id_material . "<br>";
    echo "<span style='color:red';>qnt- </span>" . $qnt . "<br>";
    echo "<span style='color:red';>vl_uni - </span>" . $vl_uni . "<br>";
    echo "<span style='color:red';>nf - </span>" . $nf . "<br>";
    echo "<span style='color:red';>tipo_verba - </span>" . $tipo_verba . "<br>";
    echo "<span style='color:red';>documento - </span>" . $documento . "<br>";
    echo "<span style='color:red';>und_medida - </span>" . $und_medida . "<br>";
    echo "<span style='color:red';>id_opm - </span>" . $id_opm . "<br>";
    echo "<span style='color:red';>status - </span>" . $status . "<br>";
    echo "<span style='color:red';>validade - </span>" . $validade . "<br>";
    echo "<span style='color:red';>dt_doc - </span>" . $dt_doc . "<br>";
    echo "<span style='color:red';>obs - </span>" . $obs . "<br>";
    echo "<span style='color:red';>contrato - </span>" . $contrato . "<br>";
    echo "<span style='color:red';>empenho - </span>" . $empenho . "<br>";
    echo "<span style='color:red';>ata - </span>" . $ata . "<br>";
    echo "<span style='color:red';>processo - </span>" . $processo . "<br>";

    try {
        entradamaterial::inserir(
            $id_fornecedor,
            $id_material,
            $qnt,
            $qnt_atual,
            $vl_uni,
            $vl_total,
            $data,
            $nf,
            $tipo_verba,
            $documento,
            $und_medida,
            $id_opm,
            $status,
            $validade,
            $dt_doc,
            $obs,
            $contrato,
            $empenho,
            $ata,
            $processo
  );
        echo "<meta http-equiv='refresh' content='0;URL=../receber_material.php?ok=inserir' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}

if (isset($_REQUEST['deletar']) and $_REQUEST['deletar'] == true and is_numeric($_REQUEST['id'])) {

    $id = $_REQUEST['id'];

    try {
        material::delete($id);
        echo "<meta http-equiv='refresh' content='0;URL=../receber_material.php?ok=delete' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        echo "<meta http-equiv='refresh' content='0;URL=../_cadastrar_material.php?ok=error' >";
        exit;
    }
}

if (isset($_REQUEST['enviarATUALIZAR'])) {

    $id                  = $_REQUEST['idAtualizar'];
    $id_fornecedor       = $_REQUEST['id_fornecedorAtualizar'];
    $id_material         = $_REQUEST['id_materialAtualiza'];
    $qnt                 = $_REQUEST['qntAtualizar'];
    $qnt_atual           = $_REQUEST['qnt_atualAtualizar'];
    $vl_uni              = $_REQUEST['vl_uniAtualizar'];
    $vl_total            = $_REQUEST['vltotalAtualizar'];
    $data                = $_REQUEST['dataAtualizar'];
    $nf                  = $_REQUEST['nfAtualizar'];
    $tipo_verba          = $_REQUEST['tipo_verbaAtualizar'];
    $documento           = $_REQUEST['documentoAtualizar'];
    $und_medida          = $_REQUEST['und_medidaAtualizar'];
    $id_opm              = $_REQUEST['id_opmAtualizar'];
    $status              = $_REQUEST['statusAtualizar'];
    $validade            = $_REQUEST['validadeAtualizar'];
    $user                = $_REQUEST['userAtualizar'];
    $dt_doc              = $_REQUEST['dt_docAtualizar'];
    $rg_status           = $_REQUEST['rg_statusAtualizar'];
    $obs                 = $_REQUEST['obsAtualizar'];
    $contrato            = $_REQUEST['contratotualizar'];
    $empenho             = $_REQUEST['empenhoAtualizar'];
    $ata                 = $_REQUEST['ataAtualizar'];
    $processo            = $_REQUEST['processoAtualizar'];
    $rg_conferente       = $_REQUEST['rg_conferenteAtualizar'];
    try {
        material::atualizar(
            $id_fornecedor,
            $id_material,
            $qnt,
            $qnt_atual,
            $vl_uni,
            $vl_total,
            $data,
            $nf,
            $tipo_verba,
            $documento,
            $und_medida,
            $id_opm,
            $status,
            $validade,
            $user,
            $dt_doc,
            $rg_status,
            $obs,
            $contrato,
            $empenho,
            $ata,
            $processo,
            $rg_conferente,
            $id
        );
        echo "<meta http-equiv='refresh' content='0;URL=../receber_material.php?ok=atualizar' >";
        exit;
    } catch (PDOException $e) {
        echo "Erro" . $e->getMessage();
        exit;
    }
}