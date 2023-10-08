<?php

namespace VarejoFacil\Models;

class Estoque extends Entidade
{
    private $id;
    private $lojaId;
    private $produtoId;
    private $localId;
    private $saldo;

    function __construct(Int $id, Int $lojaId, Int $produtoId, Int $localId, $saldo)
    {
        $this->id = $id;
        $this->lojaId = $lojaId;
        $this->produtoId = $produtoId;
        $this->localId = $localId;
        $this->saldo = $saldo;
    }

    public function getId(): Int
    {
        return $this->id;
    }

    public function getProdutoId()
    {
        return $this->produtoId;
    }

    public function getLojaId()
    {
        return $this->lojaId;
    }

    public function getLocalId()
    {
        return $this->localId;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }
}
