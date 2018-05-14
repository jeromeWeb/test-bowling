<?php

namespace Tests\Bowling\Entity;

use PHPUnit\Framework\TestCase;
use Bowling\Entity\Frame;

final class FameTest extends TestCase
{
    public function testResultThrow(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $frame = new Frame();
        $frame->addResultThrow("abc");
    }

    public function testZeroResultThrow(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $frame = new Frame();
        $frame->addResultThrow(0);
    }

    public function testImpossibleResultThrow(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $frame = new Frame();
        $frame->addResultThrow(9);
        $frame->addResultThrow(9);
    }

    public function testTooManyThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $frame = new Frame();
        $frame->addResultThrow(1);
        $frame->addResultThrow(1);
        $frame->addResultThrow(1);
    }

    public function testNoThrowAfterStrike(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $frame = new Frame();
        $frame->addResultThrow("x");
        $frame->addResultThrow("1");
    }

}