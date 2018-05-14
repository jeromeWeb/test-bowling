<?php
/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 13:36
 */

namespace Bowling\Manager;

use Bowling\Entity\Frame;
use Bowling\Entity\Game;

class PlayerManager
{
    private $game;

    /**
     * PlayerManager constructor.
     */
    public function __construct()
    {
        $this->game = new Game();

        for($i=0; $i<Game::FRAMES_PER_GAME; $i++)
        {
            $frame = new Frame();
            $frame->setSequence($i+1);
            $this->game->addFrame($frame);
        }
    }

    /**
     *  Set score string like 12x9-5/9---329/719-
     *  valid characters are 1 to 9, x for strike, / for spare and - for gutter
     *
     * @param string $scenario
     */
    public function setScenario(string $scenario): void
    {
        $this->game->setScenario($scenario);
    }

    public function getScore(): int
    {
        return $this->game->getScore();
    }
}