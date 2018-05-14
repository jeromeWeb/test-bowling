<?php

/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 13:40
 */

namespace Bowling\Interfaces;

interface FrameInterface
{
    public function getPoints(): int;

    public function isOver(): bool;

    public function addResultThrow(string $result): void;

    public function addNextResultThrow(string $result): void;

}