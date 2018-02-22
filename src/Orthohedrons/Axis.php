<?php

namespace Ginsen\Orthohedrons;

use Assert\Assert;
use Assert\LazyAssertionException;
use Ginsen\Orthohedrons\Exceptions\AxisInvalidArgumentException;

/**
 * Class Axis
 * @package Ginsen\Orthohedrons
 */
class Axis implements IAxis
{
    /** @var int */
    protected $initPoint;

    /** @var int */
    protected $endPoint;


    /**
     * Axis constructor.
     *
     * @param int $initPoint
     * @param int $endPoint
     */
    public function __construct(int $initPoint, int $endPoint)
    {
        try {
            Assert::lazy()
                  ->that($initPoint, 'initPoint')->integer()
                  ->that($endPoint, 'endPoint')->integer()
                  ->verifyNow();

            $this->initPoint = $initPoint;
            $this->endPoint  = $endPoint;
        } catch (LazyAssertionException $e) {
            throw new AxisInvalidArgumentException($e->getMessage());
        }
    }


    /**
     * @inheritdoc
     */
    public function initPoint(): int
    {
        return $this->initPoint;
    }


    /**
     * @inheritdoc
     */
    public function endPoint(): int
    {
        return $this->endPoint;
    }


    /**
     * @inheritdoc
     */
    public function getDistance(): int
    {
        return abs($this->endPoint - $this->initPoint);
    }


    /**
     * @inheritdoc
     */
    public function getIntersectedAxis(IAxis $axis): IAxis
    {
        $initPoint = ($this->initPoint < $axis->initPoint())
            ? $axis->initPoint()
            : $this->initPoint;

        $endPoint = ($this->endPoint < $axis->endPoint())
            ? $this->endPoint
            : $axis->endPoint();

        return new self($initPoint, $endPoint);
    }


    /**
     * @inheritdoc
     */
    public function isIntersected(IAxis $axis): bool
    {
        $isCrossed = (
            $this->isCrossed($this->initPoint, $this->endPoint, $axis->initPoint()) ||
            $this->isCrossed($this->initPoint, $this->endPoint, $axis->endPoint()) ||
            $this->isCrossed($axis->initPoint(), $axis->endPoint(), $this->initPoint) ||
            $this->isCrossed($axis->initPoint(), $axis->endPoint(), $this->endPoint)
        );

        return $isCrossed;
    }


    /**
     * @param int $initPoint
     * @param int $endPoint
     * @param int $reference
     * @return bool
     */
    protected function isCrossed(int $initPoint, int $endPoint, int $reference): bool
    {
        return $reference > $initPoint && $reference < $endPoint;
    }
}