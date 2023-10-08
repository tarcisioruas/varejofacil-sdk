<?php

namespace VarejoFacil\Services;

use \VarejoFacil\VarejoFacilSDK;
use \VarejoFacil\Models\Loja;
use \VarejoFacil\Response;

class LojaService
{
    private $resource = '/v1/pessoa/lojas';
    private $sdk;
    private $waitTime = 30;

    function __construct(VarejoFacilSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function list(String $filter = ''): Response
    {
        $start = 0;
        $total = 0;

        if ($filter) {
            $filter .= '&q=' . $filter;
        }

        do {
            $resposta = $this->sdk->get($this->resource . '?start=' . $start . '&count=500' . $filter, []);

            $total = $resposta->total;
            $start += $resposta->count;

            $resp = new Response($resposta->total, $resposta->count, $resposta->start);

            if (isset($resposta->items)) {
                foreach ($resposta->items as $item) {
                    $loja = new Loja($item->id, $item->nome);
                    $resp->addItem($loja);
                }
            }

            //Pausa de tempo para evitar sobrecarga ao servidor
            if ($total > $start) {
                sleep($this->waitTime);
            }
        } while ($start < $total);


        return $resp;
    }
}
