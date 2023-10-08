<?php

namespace VarejoFacil;

use \VarejoFacil\Interfaces\HttpInterface;
use \VarejoFacil\Exceptions\VarejoFacilSDKException;

class VarejoFacilSDK
{
    private $url;
    private $accessToken;

    private $refreshToken;
    private $http;

    function __construct(String $dominio, String $usuario, String $senha, HttpInterface $http = null)
    {
        $this->http = is_null($http) ? new CurlHttp() : $http;
        $usuario = is_null($usuario) ? getenv('VAREJO_FACIL_USUARIO') : $usuario;
        $senha = is_null($senha) ? getenv('VAREJO_FACIL_SENHA') : $senha;
        $dominio = is_null($dominio) ? getenv('VAREJO_FACIL_DOMINIO') : $dominio;

        $this->buildUrl($dominio);

        if (is_null($this->accessToken)) {
            $this->authenticate($usuario, $senha);
        }
    }

    private function buildHeader()
    {
        return [
            'Accept: application/json',
            'Content-Type: application/json',
            'authorization: ' . $this->accessToken
        ];
    }

    private function buildUrl($dominio)
    {
        if (!$dominio) {
            throw new VarejoFacilSDKException('Dominio não infomado ao instanciar "VarejoFacilSDK" ou via váriaveis de ambiente');
        }

        $this->url = $dominio;
        if (!strstr($this->url, 'https://')) {
            $this->url = 'https://' . $this->url;
        }

        if (substr($this->url, -1) != '/') {
            $this->url .= '/';
        }
    }

    private function buildResourceUrl($resource)
    {
        if (substr($resource, 0, 1) == '/') {
            $resource = substr($resource, 1);
        }

        return $this->url . 'api/' . $resource;
    }

    private function authenticate(String $usuario, String $senha)
    {
        if (!$usuario) {
            throw new VarejoFacilSDKException('Usuário não infomado ao instanciar "VarejoFacilSDK" ou via váriaveis de ambiente');
        }

        if (!$senha) {
            throw new VarejoFacilSDKException('Senha não infomada ao instanciar "VarejoFacilSDK" ou via váriaveis de ambiente');
        }


        $authUrl = 'api/auth';

        $response = $this->http->post($this->url . $authUrl, json_encode([
            'username' => $usuario,
            'password' => $senha
        ]),  ['Accept: application/json', 'Content-Type: application/json']);

        if ($response) {
            $decodeResonde = json_decode($response);

            if (isset($decodeResonde->accessToken)) {
                $this->accessToken = $decodeResonde->accessToken;
            }

            if (isset($decodeResonde->refreshToken)) {
                $this->refreshToken = $decodeResonde->refreshToken;
            }
        }
    }

    private function logout()
    {
        if ($this->isAuthentidated()) {
            $logautUrl = 'auth/logout';
            $header = $this->buildHeader();
            $this->http->get($this->url . $logautUrl, [],  $header);
        }
    }

    public function post($resource, array $params)
    {
        $header = $this->buildHeader();
        $resourceUrl = $this->buildResourceUrl($resource);
        $retorno = $this->http->post($resourceUrl, json_encode($params), $header);
        return json_decode($retorno);
    }

    public function put($resource, array $params)
    {
        $header = $this->buildHeader();
        $resourceUrl = $this->buildResourceUrl($resource);
        $resp = $this->http->put($resourceUrl, json_encode($params), $header);
        $info = $this->http->getInfo();
        if (isset($info['http_code']) && $info['http_code'] == 200) {
            return true;
        }

        var_dump($resp);

        return false;
    }

    public function delete($resource)
    {
        $header = $this->buildHeader();
        $resourceUrl = $this->buildResourceUrl($resource);
        $resp = $this->http->delete($resourceUrl, $header);
        $info = $this->http->getInfo();
        if (isset($info['http_code']) && $info['http_code'] == 200) {
            return true;
        }
        return false;
    }

    public function get($resource, array $params)
    {
        $headers = $this->buildHeader();
        $resourceUrl = $this->buildResourceUrl($resource);
        return json_decode($this->http->get($resourceUrl, $params, $headers));
    }

    public function isAuthentidated()
    {
        return !is_null($this->accessToken);
    }

    public function getUrl()
    {
        return $this->url;
    }

    function __destruct()
    {
        $this->logout();
    }
}
