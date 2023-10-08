<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use VarejoFacil\Models\Produto;

final class ProdutoTest extends TestCase
{
    public function testGetId(): void
    {
        $id = 10;
        $descricao = 'Um produto qualquer';
        $produto = new Produto(10, 'Um produto qualquer');

        $this->assertEquals(10, $produto->getId());
    }

    public function testGetDescricao(): void
    {
        $produto = new Produto(10, 'Um produto qualquer');

        $this->assertEquals('Um produto qualquer', $produto->getDescricao());
    }
}
