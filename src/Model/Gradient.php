<?php

namespace App\Model;

class Gradient
{
    private ?float $rate;
    private ?float $setPoint;
    private ?float $holdTime;
    private ?float $runTime;

    public function __construct(array $data)
    {
        $this->rate = (float) $data[0] ?? null;
        $this->setPoint = (float) $data[1] ?? null;
        $this->holdTime = (float) $data[2] ?? null;
        $this->runTime = (float) $data[3] ?? null;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getSetPoint(): float
    {
        return $this->setPoint;
    }

    public function getHoldTime(): float
    {
        return $this->holdTime;
    }

    public function getRunTime(): float
    {
        return $this->runTime;
    }
}
