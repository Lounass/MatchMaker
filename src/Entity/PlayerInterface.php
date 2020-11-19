<?php

declare(strict_types=1);

namespace App\Entity;

interface PlayerInterface {
    public function updateRatioAgainst(PlayerInterface $player, $result): void;
    public function getLevel(): float;
}


