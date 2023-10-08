<?php

namespace VarejoFacil;

use \VarejoFacil\Models\Entidade;

class Response
{
    private $itens = [];
    private $total = 0;
    private $count = 0;
    private $start = 0;

    function __construct($total = 0, $count = 0, $start = 0)
    {
        $this->total = $total;
        $this->count = $count;
        $this->start = $start;
    }

    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function addItem(Entidade $item)
    {
        array_push($this->itens, $item);
    }

    public function listItens()
    {
        return $this->itens;
    }

    public function getFirst()
    {
        if (isset($this->itens[0])) {
            return $this->itens[0];
        }

        return null;
    }

    public function moveStart($moviments)
    {
        $this->start += $moviments;
        return $this;
    }
}
