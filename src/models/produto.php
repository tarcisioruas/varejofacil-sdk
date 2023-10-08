<?php

namespace VarejoFacil\Models;

class Produto extends Entidade
{
    private $id;
    private $descricao;
    private $precos = [];
    private $estoques = [];
    private $codigosAuxiliares = [];
    private $imagem;
    private $ncm;
    private $balanca;
    private $altura;
    private $largura;
    private $comprimento;
    private $pesoBruto;

    function __construct(Int $id, String $descricao)
    {
        $this->id = $id;
        $this->descricao = $descricao;
    }

    public function getId(): Int
    {
        return $this->id;
    }

    public function getDescricao(): String
    {
        return $this->descricao;
    }

    public function setImagem(String $imagem): Produto
    {
        $this->imagem = $imagem;
        return $this;
    }

    public function setPrecos(array $precos): Produto
    {
        $this->precos = $precos;
        return $this;
    }

    public function getPrecos()
    {
        return $this->precos;
    }

    public function setNCM($ncm)
    {
        $this->ncm = $ncm;
        return $this;
    }

    public function getNCM()
    {
        return $this->ncm;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setEstoques(array $estoques)
    {
        $this->estoques = $estoques;
        return $this;
    }

    public function getEstoques()
    {
        return $this->estoques;
    }

    public function setCodigosAuxiliares(array $codigosAuxiliares)
    {
        $this->codigosAuxiliares = $codigosAuxiliares;
        return $this;
    }

    public function getCodigosAuxiliares()
    {
        return $this->codigosAuxiliares;
    }

    public function setBalanca(bool $balanca)
    {
        $this->balanca = $balanca;
        return $this;
    }

    public function isBalanca(): bool
    {
        return $this->balanca;
    }

    public function setAltura($altura)
    {
        $this->altura = $altura;
        return $this;
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function setLargura($largura)
    {
        $this->largura = $largura;
        return $this;
    }

    public function getLargura()
    {
        return $this->largura;
    }

    public function setComprimento($comprimento)
    {
        $this->comprimento = $comprimento;
        return $this;
    }

    public function getComprimento()
    {
        return $this->comprimento;
    }

    public function setPesoBruto($pesoBruto)
    {
        $this->pesoBruto = $pesoBruto;
        return $this;
    }

    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }
}
