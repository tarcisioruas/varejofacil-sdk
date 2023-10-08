<?php

namespace VarejoFacil\Services;

use \VarejoFacil\Models\CodigoAuxiliar;
use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Response;

class CodigoAuxiliarService
{
    private $sdk;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function listByProductId(Int $produtoId)
    {
        $resource = '/v1/produto/produtos/' . $produtoId . '/codigos-auxiliares';
        $resposta = $this->sdk->get($resource, []);
        $codigos = [];
        if (isset($resposta->items)) {
            foreach ($resposta->items as $item) {
                $codigo = new CodigoAuxiliar($item->id, $item->tipo, $item->fator, $item->eanTributado, $item->produtoId);
                array_push($codigos, $codigo);
            }
        }

        return $codigos;
    }

    public function list(String $filter = '')
    {
        if ($filter) {
            $filter .= '&q=' . $filter;
        }

        $resource = '/v1/produto/codigos-auxiliares';
        $resp = new Response(0, 500, 0);

        do {
            $resposta = $this->sdk->get($resource . '?start=' . $resp->getStart() . '&count=' . $resp->getCount() . $filter, []);
            $resp->setTotal($resposta->total)
                ->setCount($resposta->count)
                ->moveStart($resposta->count);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {
                    $codigo = new CodigoAuxiliar($item->id, $item->tipo, $item->fator, $item->eanTributado, $item->produtoId);
                    $resp->addItem($codigo);
                }
            }
        } while ($resp->getStart() < $resp->getTotal());


        return $resp;
    }

    public function atualizar(CodigoAuxiliar $codigoAuxiliar)
    {
        $id = $codigoAuxiliar->getId();
        $produtoId = $codigoAuxiliar->getProdutoId();
        $resource = '/v1/produto/produtos/' . $produtoId . '/codigos-auxiliares/' . $id;
        $resposta = $this->sdk->put($resource, [
            'id' => $codigoAuxiliar->getId(),
            'tipo' => $codigoAuxiliar->getTipo(),
            'fator' => $codigoAuxiliar->getFator(),
            'eanTributado' => $codigoAuxiliar->isTributado(),
            'produtoId' => $codigoAuxiliar->getProdutoId()
        ]);

        return $resposta;
    }
}
