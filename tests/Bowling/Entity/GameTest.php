<?php
/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 16:01
 */

namespace Tests\Bowling\Entity;

use Bowling\Entity\Frame;
use PHPUnit\Framework\TestCase;
use Bowling\Entity\Game;

final class GameTest extends TestCase
{
    public function testParseScenario(): void
    {
        $game = new Game();

        $frame1 = $this->createMock(Frame::class);
        $frame1->expects($this->exactly(2))
            ->method('addResultThrow')
            ->withConsecutive([1], [3]);

        $frame1->method('isOver')
            ->willReturn(false, true);

        $game->addFrame($frame1);

        $frame2 = $this->createMock(Frame::class);

        $frame2->expects($this->once())
            ->method('addResultThrow')
            ->with("x");

        $frame2->method('isOver')
            ->willReturn(true);

        $game->addFrame($frame2);

        $game->setScenario("13x");
    }

    public function testGetScore()
    {
        $game = new Game();

        $frame1 = $this->createMock(Frame::class);
        $frame1->expects($this->once())
            ->method('getPoints')
            ->willReturn(3);

        $game->addFrame($frame1);

        $frame2 = $this->createMock(Frame::class);

        $frame2->method('getPoints')
            ->willReturn(4);

        $game->addFrame($frame2);

        $this->assertEquals(7, $game->getScore());

    }

}