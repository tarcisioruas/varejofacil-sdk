<?php

namespace VarejoFacil;

use \VarejoFacil\Interfaces\HttpInterface;
use \VarejoFacil\Exceptions\HttpException;

class CurlHttp implements HttpInterface
{
    private $info = [];

    public function post($url, $dados, array $cabecalhos)
    {
        return $this->sendRequest($url, $dados, $cabecalhos, 'POST');
    }

    public function put($url, $dados, array $cabecalhos)
    {
        return $this->sendRequest($url, $dados, $cabecalhos, 'PUT');
    }

    public function get($url, $dados, array $cabecalhos)
    {
        return $this->sendRequest($url, $dados, $cabecalhos);
    }

    public function delete($url, $cabecalhos)
    {
        return $this->sendRequest($url, null, $cabecalhos, 'DELETE');
    }

    private function sendRequest($url, $dados, array $cabecalhos, $method = 'GET')
    {

        $canal = curl_init();

        //for debug only!
        curl_setopt($canal, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($canal, CURLOPT_SSL_VERIFYPEER, false);


        if ($method == 'POST') {
            curl_setopt($canal, CURLOPT_URL, $url);
            curl_setopt($canal, CURLOPT_POST, 1);

            if (isset($dados)) {
                curl_setopt($canal, CURLOPT_POSTFIELDS, $dados);
            }
        }

        if ($method == 'PUT') {
            curl_setopt($canal, CURLOPT_URL, $url);
            curl_setopt($canal, CURLOPT_POST, 1);
            curl_setopt($canal, CURLOPT_CUSTOMREQUEST,  'PUT');

            if (isset($dados)) {
                curl_setopt($canal, CURLOPT_POSTFIELDS, $dados);
            }
        }

        if ($method == 'DELETE') {
            curl_setopt($canal, CURLOPT_URL, $url);
            curl_setopt($canal, CURLOPT_MAXREDIRS, 3);
            curl_setopt($canal, CURLOPT_TIMEOUT, 5);
            curl_setopt($canal, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($canal, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }


        if ($method == 'PATCH') {
            curl_setopt($canal, CURLOPT_URL, $url);
            curl_setopt($canal, CURLOPT_ENCODING, "");
            curl_setopt($canal, CURLOPT_MAXREDIRS, 3);
            curl_setopt($canal, CURLOPT_TIMEOUT, 10);
            curl_setopt($canal, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($canal, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if (isset($data)) {
                curl_setopt($canal, CURLOPT_POSTFIELDS, $data);
            }
        }



        if ($method == 'GET') {

            if (isset($data) && is_array($data)) {
                $url = $url . '?' . http_build_query($data);
            }

            curl_setopt($canal, CURLOPT_URL, $url);
        }

        curl_setopt($canal, CURLOPT_HTTPHEADER, $cabecalhos);
        curl_setopt($canal, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($canal);

        if (!curl_errno($canal)) {
            $this->info = curl_getinfo($canal);
        }

        if ($response === false) {
            throw new HttpException(('Erro ao efetuar requisição: ' . curl_error($canal)), 1, $url, 'get');
        }

        curl_close($canal);
        return $response;
    }

    public function getInfo()
    {
        return $this->info;
    }
}
