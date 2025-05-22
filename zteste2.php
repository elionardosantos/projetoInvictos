<?php

    // GERANDO AS PARCELAS DO PEDIDO
    $valorTotal = 100;
    $nParcelas = 5;


    if(isset($nParcelas) && $nParcelas > 0){
        $valorParcelas = ($valorTotal / $nParcelas);
        $parcela = 1;
        while($parcela <= $nParcelas){

            $data = date('Y-m-d', strtotime("+$parcela month"));
            $parcelas[$parcela]['dataVencimento'] = $data;
            $parcelas[$parcela]['formaPagamento']['id'] = 4872848;
            
            if($parcela < $nParcelas){
                $parcelas[$parcela]['valor'] = ceil($valorParcelas);
            } elseif ($parcela == $nParcelas){
                $parcelaFinal = ($valorTotal - (ceil($valorParcelas) * ($nParcelas - 1)));
                $parcelas[$parcela]['valor'] = $parcelaFinal;

            }

            $parcela++;
        }
    }elseif(isset($nParcelas) && $nParcelas == 0){
        $data = date('Y-m-d');
        $parcelas[0]['dataVencimento'] = $data;
        $parcelas[0]['valor'] = $valorTotal;
        $parcelas[0]['formaPagamento']['id'] = $condicaoPagamento;
    }

    print_r($parcelas);