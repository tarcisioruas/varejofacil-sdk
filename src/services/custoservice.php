<?php

namespace VarejoFacil\Services;

use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Models\Custo;
use \VarejoFacil\Response;

class CustoService
{
    private $sdk;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function listByProductId(Int $produtoId, array $filter = [])
    {
        $resource = '/v1/produto/produtos/' . $produtoId . '/custos';
        $resposta = $this->sdk->get($resource, []);
        $custos = [];
        if ($resposta) {
            foreach ($resposta as $item) {
                $custo = new Custo($item->id, $item->produtoId, $item->lojaId, isset($item->custoReposicao) ? $item->custoReposicao : 0.00);
                $custo->setCustoMedio($item->custoMedio)
                    ->setCustoFiscal(isset($item->custoFiscal) ? $item->custoFiscal : 0.00);

                if (isset($item->idExterno)) {
                    $custo->setIdExterno($item->idExterno);
                }

                array_push($custos, $custo);
            }
        }

        return $custos;
    }

    public function list(String $filter = '')
    {

        if ($filter) {
            $filter .= '&q=' . $filter;
        }

        $resource = '/v1/produto/custos';

        $resp = new Response(0, 500, 0);

        do {
            $resposta = $this->sdk->get($resource . '?start=' . $resp->getStart() . $filter . '&count=' . $resp->getCount(), []);

            $resp->setTotal($resposta->total)
                ->setCount($resposta->count)
                ->moveStart($resposta->count);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {

                    $custo = new Custo($item->id, $item->produtoId, $item->lojaId, isset($item->custoReposicao) ? $item->custoReposicao : 0.00);
                    $custo->setCustoMedio($item->custoMedio)
                        ->setCustoFiscal(isset($item->custoFiscal) ? $item->custoFiscal : 0.00);

                    if (isset($item->idExterno)) {
                        $custo->setIdExterno($item->idExterno);
                    }

                    $resp->addItem($custo);
                }
            }
        } while ($resp->getStart() < $resp->getTotal());


        return $resp;
    }

    public function atualizar(Custo $custo)
    {
        $id = $custo->getId();
        $resource = '/v1/produto/custos/' . $id;

        $custoArray = [
            'id' => $custo->getId(),
            //'idExterno' => !empty($custo->getIdExterno()) && $custo->getIdExterno() != 0 ? $custo->getIdExterno() : '',
            'lojaId' => $custo->getLojaId(),
            'produtoId' => $custo->getProdutoId(),
            'custoReposicao' => $custo->getCustoReposicao(),
            'custoFiscal' => $custo->getCustoFiscal(),
            'custoMedio' => $custo->getCustoMedio()
        ];


        $resposta = $this->sdk->put($resource, $custoArray);

        return $resposta;
    }


    public function delete(Custo $custo)
    {
        $id = $custo->getId();
        $resource = '/v1/produto/custos/' . $id;

        $resposta = $this->sdk->delete($resource);

        return $resposta;
    }
}
