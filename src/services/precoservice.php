<?php

namespace VarejoFacil\Services;

use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Models\Preco;
use \VarejoFacil\Response;

class PrecoService
{
    private $sdk;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function listByProductId(Int $produtoId, array $filter = [])
    {
        $resource = '/v1/produto/produtos/' . $produtoId . '/precos';
        $resposta = $this->sdk->get($resource, []);
        $precos = [];
        if ($resposta) {
            foreach ($resposta as $item) {
                $preco = new Preco($item->id, $item->produtoId, $item->lojaId, $item->precoVenda1);
                array_push($precos, $preco);
            }
        }

        return $precos;
    }

    public function list(String $filter = '')
    {

        if ($filter) {
            $filter .= '&q=' . $filter;
        }

        $resource = '/v1/produto/precos';

        $resp = new Response(0, 500, 0);

        do {
            $resposta = $this->sdk->get($resource . '?start=' . $resp->getStart() . $filter . '&count=' . $resp->getCount(), []);

            $resp->setTotal($resposta->total)
                ->setCount($resposta->count)
                ->moveStart($resposta->count);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {

                    $preco = new Preco($item->id, $item->produtoId, $item->lojaId);

                    $quantidadeMinimaPreco2 = null;
                    if (isset($item->quantidadeMinimaPreco2)) {
                        $quantidadeMinimaPreco2 = $item->quantidadeMinimaPreco2;
                    }


                    $quantidadeMinimaPreco3 = null;
                    if (isset($item->quantidadeMinimaPreco3)) {
                        $quantidadeMinimaPreco3 = $item->quantidadeMinimaPreco3;
                    }

                    $preco->setPrecoVenda1($item->precoVenda1)
                        ->setPrecoOferta1($item->precoOferta1)
                        ->setPrecoVenda2($item->precoVenda2)
                        ->setPrecoOferta2($item->precoOferta2)
                        ->setQuantidadeMinimaPreco2($quantidadeMinimaPreco2)
                        ->setPrecoVenda3($item->precoVenda3)
                        ->setPrecoOferta3($item->precoOferta3)
                        ->setQuantidadeMinimaPreco3($quantidadeMinimaPreco3);

                    $resp->addItem($preco);
                }
            }
        } while ($resp->getStart() < $resp->getTotal());


        return $resp;
    }
}
