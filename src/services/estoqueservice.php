<?php

namespace VarejoFacil\Services;

use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Models\Estoque;
use \VarejoFacil\Response;

class EstoqueService
{
    private $sdk;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function listByProductId(Int $produtoId)
    {
        $resource = 'v1/estoque/saldos';
        $resposta = $this->sdk->get($resource . '?q=produtoId==' . $produtoId, []);

        $estoques = [];
        if (isset($resposta->items)) {
            foreach ($resposta->items as $item) {
                $estoque = new Estoque($item->id, $item->lojaId, $item->produtoId, $item->localId, $item->saldo);
                array_push($estoques, $estoque);
            }
        }

        return $estoques;
    }

    public function list(String $filter = '')
    {
        if ($filter) {
            $filter .= '&q=' . $filter;
        }



        $resource = 'v1/estoque/saldos';
        $resp = new Response(0, 500, 0);
        do {
            $resposta = $this->sdk->get($resource . '?start=' . $resp->getStart() . $filter . '&count=' . $resp->getCount(), []);
            $resp->setTotal($resposta->total)
                ->setCount($resposta->count)
                ->moveStart($resposta->count);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {
                    $estoque = new Estoque($item->id, $item->lojaId, $item->produtoId, $item->localId, $item->saldo);
                    $resp->addItem($estoque);
                }
            }
        } while ($resp->getStart() < $resp->getTotal());


        return $resp;
    }
}
