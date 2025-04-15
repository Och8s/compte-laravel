<?php

namespace App\Services;

class Compte
{
    private float $saldo = 0;
    private float $totalTransferitAvui = 0;

    private const MAX_INGRES = 6000.00;
    private const MAX_RETIRADA = 6000.00;
    private const MAX_TRANSFERENCIA_DIA = 3000.00;

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function ingressar(float $quantitat): bool
    {
        if ($quantitat <= 0 || $quantitat > self::MAX_INGRES || round($quantitat, 2) != $quantitat) {
            return false;
        }

        $this->saldo += $quantitat;
        return true;
    }

    public function retirar(float $quantitat): bool
    {
        if ($quantitat <= 0 || $quantitat > self::MAX_RETIRADA || $quantitat > $this->saldo || round($quantitat, 2) != $quantitat) {
            return false;
        }

        $this->saldo -= $quantitat;
        return true;
    }

    public function transferir(Compte $destinatari, float $quantitat): bool
    {
        if ($quantitat <= 0 || $quantitat > $this->saldo || $this->totalTransferitAvui + $quantitat > self::MAX_TRANSFERENCIA_DIA || round($quantitat, 2) != $quantitat) {
            return false;
        }

        $this->saldo -= $quantitat;
        $destinatari->saldo += $quantitat;
        $this->totalTransferitAvui += $quantitat;
        return true;
    }
}
