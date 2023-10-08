<?php

namespace VarejoFacil\Models;

class Preco extends Entidade
{
    private $id;
    private $lojaId;
    private $produtoId;
    private $precoVenda1 = 0;
    private $precoOferta1 = 0;
    private $precoVenda2 = 0;
    private $precoOferta2 = 0;
    private $quantidadeMinimaPreco2 = 0;
    private $precoVenda3 = 0;
    private $precoOferta3 = 0;
    private $quantidadeMinimaPreco3 = 0;

    function __construct(Int $id, Int $produtoId, Int $lojaId)
    {
        $this->id = $id;
        $this->produtoId = $produtoId;
        $this->lojaId = $lojaId;
    }

    public function getId(): Int
    {
        return $this->id;
    }

    public function setPrecoVenda1($precoVenda1)
    {
        $this->precoVenda1 = $precoVenda1;
        return $this;
    }

    public function getPrecoVenda1(): Float
    {
        return $this->precoVenda1;
    }

    public function setPrecoOferta1($precoOferta1)
    {
        $this->precoOferta1 = $precoOferta1;
        return $this;
    }

    public function getPrecoOferta1(): Float
    {
        return $this->precoOferta1;
    }

    public function setPrecoVenda2($precoVenda2)
    {
        $this->precoVenda2 = $precoVenda2;
        return $this;
    }

    public function getPrecoVenda2(): Float
    {
        return $this->precoVenda2;
    }

    public function setPrecoOferta2($precoOferta2)
    {
        $this->precoOferta2 = $precoOferta2;
        return $this;
    }

    public function getPrecoOferta2(): Float
    {
        return $this->precoOferta2;
    }

    public function setQuantidadeMinimaPreco2($quantidadeMinimaPreco2)
    {
        $this->quantidadeMinimaPreco2 = $quantidadeMinimaPreco2;
        return $this;
    }

    public function getQuantidadeMinimaPreco2(): Float
    {
        return $this->quantidadeMinimaPreco2;
    }

    public function setPrecoVenda3($precoVenda3)
    {
        $this->precoVenda3 = $precoVenda3;
        return $this;
    }

    public function getPrecoVenda3(): Float
    {
        return $this->precoVenda3;
    }

    public function setPrecoOferta3($precoOferta3)
    {
        $this->precoOferta3 = $precoOferta3;
        return $this;
    }

    public function getPrecoOferta3(): Float
    {
        return $this->precoOferta3;
    }

    public function setQuantidadeMinimaPreco3($quantidadeMinimaPreco3)
    {
        $this->quantidadeMinimaPreco3 = $quantidadeMinimaPreco3;
        return $this;
    }

    public function getQuantidadeMinimaPreco3(): Float
    {
        return $this->quantidadeMinimaPreco3;
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
