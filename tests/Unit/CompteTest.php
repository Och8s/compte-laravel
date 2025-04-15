<?php

namespace Tests\Unit;

use App\Services\Compte;
use PHPUnit\Framework\TestCase;

class CompteTest extends TestCase
{
    private Compte $compte;

    protected function setUp(): void
    {
        $this->compte = new Compte();
    }

    public function testCompteCreatAmbSaldoZero(): void
    {
        $this->assertEquals(0, $this->compte->getSaldo());
    }

    public function testIngressar(): void
    {
        $this->assertTrue($this->compte->ingressar(100));
        $this->assertEquals(100, $this->compte->getSaldo());

        $this->assertFalse($this->compte->ingressar(-100));
        $this->assertFalse($this->compte->ingressar(100.457));
        $this->assertTrue($this->compte->ingressar(3000));
        $this->assertFalse($this->compte->ingressar(6000.01));
    }

    public function testRetirar(): void
    {
        $this->compte->ingressar(500);
        $this->assertTrue($this->compte->retirar(100));
        $this->assertFalse($this->compte->retirar(500));
        $this->assertFalse($this->compte->retirar(-100));
        $this->assertTrue($this->compte->retirar(100.45));
        $this->assertFalse($this->compte->retirar(100.457));
    }

    public function testTransferir(): void
    {
        $compteDesti = new Compte();
        $this->compte->ingressar(500);
        $compteDesti->ingressar(50);

        $this->assertTrue($this->compte->transferir($compteDesti, 100));
        $this->assertFalse($this->compte->transferir($compteDesti, -100));
    }
}
