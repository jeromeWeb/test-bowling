<?php
/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 18:35
 */

use PHPUnit\Framework\TestCase;
use Bowling\Manager\PlayerManager;

final class PlayerManagerTest extends TestCase
{
    public function testSimpleScore()
    {
        $player = new PlayerManager();

        $this->assertEquals(0, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("---------");
        $this->assertEquals(0, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("3-3-3-");
        $this->assertEquals(9, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("123454321");
        $this->assertEquals(25, $player->getScore());
    }

    public function testSpare()
    {
        $player = new PlayerManager();

        $player->setScenario("1/");
        $this->assertEquals(10, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("1/9");
        $this->assertEquals(28, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("1/-");
        $this->assertEquals(10, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("1/1/-");
        $this->assertEquals(21, $player->getScore());

    }

    public function testStrike()
    {
        $player = new PlayerManager();

        $player->setScenario("x");
        $this->assertEquals(10, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("x--");
        $this->assertEquals(10, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("x12");
        $this->assertEquals(16, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("xxx");
        $this->assertEquals(60, $player->getScore());
    }

    public function testPerfectGame()
    {
        $player = new PlayerManager();

        $player->setScenario("xxxxxxxxxxxx");
        $this->assertEquals(300, $player->getScore());
    }

    public function testScores()
    {
        $player = new PlayerManager();

        $player->setScenario("9-9-9-9-9-9-9-9-9-9-");
        $this->assertEquals(90, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("5/5/5/5/5/5/5/5/5/5/5");
        $this->assertEquals(150, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("9-9/8-9-3/8-9");
        $this->assertEquals(79, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("633-9/9-9-9-6-9-9-");
        $this->assertEquals(82, $player->getScore());

        $player = new PlayerManager();

        $player->setScenario("7/xxxxxxxxx8/");
        $this->assertEquals(278, $player->getScore());
    }

}