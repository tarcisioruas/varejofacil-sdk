<?php

namespace VarejoFacil\Services;

use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Models\Produto;
use \VarejoFacil\Response;

class ProdutoService
{
    private $resource = '/v1/produto/produtos';
    private $sdk;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function list(String $filter = '', $count = 500): Response
    {
        if ($filter) {
            $filter .= '&q=' . $filter;
        }


        $resp = new Response(0, $count, 0);

        do {
            $resposta = $this->sdk->get($this->resource . '?start=' . $resp->getStart() . $filter . '&count=' . $resp->getCount(), []);
            $resp->setTotal($resposta->total)
                ->setCount($resposta->count)
                ->moveStart($resposta->count);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {
                    $produto = new Produto($item->id, $item->descricao);
                    $produto->setBalanca($item->enviaBalanca)
                        ->setPesoBruto(isset($item->pesoBruto) ? $item->pesoBruto : null)
                        ->setLargura($item->largura)
                        ->setAltura($item->altura)
                        ->setComprimento($item->comprimento);

                    if (isset($item->imagem)) {
                        $urlImagem = $this->sdk->getUrl() . 'arquivo/view?uuid=' . $item->imagem;
                        $produto->setImagem($urlImagem);
                    }
                    $produto->setNCM($item->ncmId);
                    $resp->addItem($produto);
                }
            }
        } while ($resp->getStart() < $resp->getTotal());

        return $resp;
    }


    public function count(String $filter = ''): int
    {
        if ($filter) {
            $filter .= '&q=' . $filter;
        }


        $resposta = $this->sdk->get($this->resource . '?start=0' . $filter . '&count=1', []);
        return $resposta->total;
    }
}
