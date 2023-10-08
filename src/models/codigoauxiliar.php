<?php

namespace VarejoFacil\Models;

class CodigoAuxiliar extends Entidade
{
    private $id;
    private $tipo;
    private $fator;
    private $tributado;
    private $produtoId;


    function __construct(String $id, String $tipo, $fator, $tributado, $produtoId, $idExterno = null)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->fator = $fator;
        $this->tributado = $tributado;
        $this->produtoId = $produtoId;
        $this->idExterno = $idExterno;
    }

    public function getId(): String
    {
        return $this->id;
    }

    public function getProdutoId()
    {
        return $this->produtoId;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getFator()
    {
        return $this->fator;
    }

    public function isTributado()
    {
        return $this->tributado;
    }

    public function setTributado(bool $tributado)
    {
        $this->tributado = $tributado;
    }

    public function __toString()
    {
        $tributado = $this->tributado ? 'Sim' : 'Não';
        return $this->produtoId . ' - ' . $this->id . ' - ' . $this->tipo . ' - ' .  $tributado . ' - ' . $this->fator;
    }
}
