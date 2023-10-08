<?php

namespace VarejoFacil\Models;

class Custo extends Entidade
{
    private $id;
    private $lojaId;
    private $produtoId;
    private $custoReposicao = 0;
    private $custoMedio = 0;
    private $custoFiscal = 0;
    private $idExterno = 0;

    function __construct(Int $id, Int $produtoId, Int $lojaId, Float $custoReposicao = 0)
    {
        $this->id = $id;
        $this->produtoId = $produtoId;
        $this->lojaId = $lojaId;
        $this->custoReposicao = $custoReposicao;
    }

    public function getId(): Int
    {
        return $this->id;
    }

    public function getIdExterno(): String
    {
        return $this->idExterno;
    }

    public function setIdExterno(String $idExterno): Custo
    {
        $this->idExterno = $idExterno;
        return $this;
    }

    public function setCustoReposicao(Float $custoReposicao = 0): Custo
    {
        $this->custoReposicao = $custoReposicao;
        return $this;
    }

    public function setCustoMedio(Float $custoMedio = 0): Custo
    {
        $this->custoMedio = $custoMedio;
        return $this;
    }

    public function setCustoFiscal(Float $custoFiscal = 0): Custo
    {
        $this->custoFiscal = $custoFiscal;
        return $this;
    }

    public function getCustoReposicao(): Float
    {
        return $this->custoReposicao;
    }

    public function getCustoMedio(): Float
    {
        return $this->custoMedio;
    }

    public function getCustoFiscal(): Float
    {
        return $this->custoFiscal;
    }


    public function getProdutoId()
    {
        return $this->produtoId;
    }

    public function getLojaId()
    {
        return $this->lojaId;
    }
}
