<?php

namespace Ginsen\Orthohedrons;

use Assert\Assert;
use Assert\LazyAssertionException;
use Ginsen\Orthohedrons\Exceptions\CuboidInvalidArgumentException;

/**
 * Class Cuboid
 * @package Ginsen\Orthohedrons
 */
class Cuboid implements ICuboid
{
    /** @var IAxis */
    protected $axisX;

    /** @var IAxis */
    protected $axisY;

    /** @var IAxis */
    protected $axisZ;

    /** @var int */
    protected $volume;

    /**
     * Cuboid constructor.
     *
     * @param IAxis $axisX
     * @param IAxis $axisY
     * @param IAxis $axisZ
     */
    public function __construct(IAxis $axisX, IAxis $axisY, IAxis $axisZ)
    {
        try {
            Assert::lazy()
                  ->that($axisX, 'axisX')->isInstanceOf(IAxis::class)
                  ->that($axisY, 'axisY')->isInstanceOf(IAxis::class)
                  ->that($axisZ, 'axisZ')->isInstanceOf(IAxis::class)
                  ->verifyNow();

            $this->axisX = $axisX;
            $this->axisY = $axisY;
            $this->axisZ = $axisZ;
            $this->calcVolume();
        } catch (LazyAssertionException $e) {
            throw new CuboidInvalidArgumentException($e->getMessage());
        }
    }


    /**
     * Calc Volume
     */
    protected function calcVolume(): void
    {
        $height = $this->axisY->getDistance();
        $width  = $this->axisX->getDistance();
        $depth  = $this->axisZ->getDistance();

        $this->volume = $height * $width * $depth;
    }


    /**
     * @inheritdoc
     */
    public function getAxisX(): IAxis
    {
        return $this->axisX;
    }


    /**
     * @inheritdoc
     */
    public function getAxisY(): IAxis
    {
        return $this->axisY;
    }


    /**
     * @inheritdoc
     */
    public function getAxisZ(): IAxis
    {
        return $this->axisZ;
    }


    /**
     * @inheritdoc
     */
    public function getVolume(): int
    {
        return $this->volume;
    }


    /**
     * @inheritdoc
     */
    public function isIntersected(ICuboid $cuboid): bool
    {
        return (
            $this->axisX->isIntersected($cuboid->getAxisX()) &&
            $this->axisY->isIntersected($cuboid->getAxisY()) &&
            $this->axisZ->isIntersected($cuboid->getAxisZ())
        );
    }


    /**
     * @inheritdoc
     */
    public function getCuboidIntersected(ICuboid $cuboid): ?ICuboid
    {
        if (!$this->isIntersected($cuboid)) {
            return null;
        }

        $newAxisX = $this->axisX->getIntersectedAxis($cuboid->getAxisX());
        $newAxisY = $this->axisY->getIntersectedAxis($cuboid->getAxisY());
        $newAxisZ = $this->axisZ->getIntersectedAxis($cuboid->getAxisZ());

        return new self($newAxisX, $newAxisY, $newAxisZ);
    }
}
