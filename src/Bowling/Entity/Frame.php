<?php
/**
 * Created by PhpStorm.
 * User: jeromeweber
 * Date: 12/05/2018
 * Time: 09:57
 */

namespace Bowling\Entity;

use Bowling\Interfaces\FrameInterface;

class Frame implements FrameInterface {

    private $resultThrows = [];
    private $nextResultThrows = [];
    private $sequence;

    /**
     *  Give points from the frame
     */
    public function getPoints(): int
    {

        $bonus1 = (array_key_exists(0, $this->nextResultThrows)?$this->resultToPin($this->nextResultThrows[0]):0);
        $bonus2 = (array_key_exists(1, $this->nextResultThrows)?$this->resultToPin($this->nextResultThrows[1], $this->nextResultThrows[0]):0);

        if ($this->isSpare())
        {
            return 10 + $bonus1;
        }

        if ($this->isStrike())
        {
            return 10 + $bonus1 + $bonus2;
        }

        return array_reduce(
            $this->resultThrows,
            function($total, $result) { return $total += $this->resultToPin($result); },
            0
        );
    }

    /**
     *  True if the frame does not expect new throw
     */
    public function isOver(): bool
    {
        if(count($this->resultThrows) == 2)
        {
            return true;
        }

        if($this->isStrike() || $this->isSpare())
        {
            return true;
        }

        return false;
    }

    /**
     * Number of the frame
     *
     * @param $sequence
     */
    public function setSequence($sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("Frame #%s", $this->sequence);
    }

    /**
     *   Returns if frame is a strike
     *
     * @return bool
     */
    public function isStrike(): bool
    {
        return array_search("x", $this->resultThrows)===false?false:true;
    }

    /**
     *   Returns if frame is a spare
     *
     * @return bool
     */
    public function isSpare(): bool
    {
        return array_search("/", $this->resultThrows)===false?false:true;
    }

    /**
     * Add code result for a throw
     *
     * @param string $result
     */
    public function addResultThrow(string $result): void
    {
        if ($this->isOver())
        {
            throw new \InvalidArgumentException("Frame is over");
        }

        switch ($result)
        {
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
            case "6":
            case "7":
            case "8":
            case "9":
            case "x":
            case "/":
            case "-":
                break;
            default:
                throw new \InvalidArgumentException(sprintf("invalid result '%s' argument, accepts [1...9], 'x', '/' or '-'", $result));
        }

        $pins = array_reduce(
            $this->resultThrows,
            function($total, $result) { return $total += $this->resultToPin($result, $this->resultThrows[0]?$this->resultThrows[0]:"");},
            0
        );

        if ($pins + $this->resultToPin($result, $this->resultThrows[0]?$this->resultThrows[0]:"") > 10)
        {
            throw new \InvalidArgumentException(sprintf("Wrong result : cannot add %s to %s pins", $result, $pins));
        }

        array_push($this->resultThrows, $result);
    }

    /**
     * add code result for next throw for bonus point
     *
     * @param string $result
     */
    public function addNextResultThrow(string $result): void
    {
        array_push($this->nextResultThrows, $result);
    }

    /**
     * Converts code result into count of reached pins
     *
     * @param string $result
     * @return int
     */
    protected function resultToPin(string $result, string $previousResult = ""): int
    {
        switch ($result)
        {
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
            case "6":
            case "7":
            case "8":
            case "9":
                return $result;
            case "x":
                return 10;
            case "/":
                return 10-($previousResult?self::resultToPin($previousResult):0);
            case "-":
                return 0;
            default:
                throw new \InvalidArgumentException(sprintf("invalid result argument '%s', accepts [1...9], 'x', or '-'", $result));
        }
    }
}
