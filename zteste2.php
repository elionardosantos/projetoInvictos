<?php

    // GERANDO AS PARCELAS DO PEDIDO
    $valorProdutos = 4560.4;

    $nParcelas = 1;
    $valorAcrescimo = 15; //percentual
    $valorDesconto = 20; //percentual

    echo "\n" . $valorProdutos;
    echo "\n" . $acrescimo = $valorProdutos * ($valorAcrescimo / 100);
    echo "\n" . $desconto = $valorProdutos * ($valorDesconto / 100);

    echo "\n" . $valorTotal = $valorProdutos - $desconto + $acrescimo;

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

    echo "\n\n";
    print_r($parcelas);