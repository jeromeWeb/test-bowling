<?php
/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 09:57
 */

namespace Bowling\Entity;

use Bowling\Interfaces\FrameInterface;

class Game {

    const FRAMES_PER_GAME = 10;
    private $frames = [];
    private $scenario = "";

    public function addFrame(FrameInterface $frame): void
    {
        array_push($this->frames, $frame);
    }

    public function setScenario(string $scenario)
    {
        $this->scenario = $scenario;

        $this->parseScenario();
    }

    protected function parseScenario()
    {
        $throws = str_split($this->scenario);

        reset($this->frames);

        foreach($throws as $index => $throw)
        {
            $frame = current($this->frames);
            $frame->addResultThrow($throw);

            if($frame->isOver())
            {
                // add next throw for bonus points (spares and strikes)
                if(array_key_exists($index+1, $throws))
                {
                    $frame->addNextResultThrow($throws[$index+1]);
                }

                if(array_key_exists($index+2, $throws)) {
                    $frame->addNextResultThrow($throws[$index + 2]);
                }

                if(next($this->frames) === false)
                {
                    break;
                }
            }
        }
    }

    /**
     * Returns score
     *
     * @return int
     */
    public function getScore(): int
    {
        return array_reduce(
            $this->frames,
            function($total, $frame) { return $total += $frame->getPoints(); },
            0);
    }
}
