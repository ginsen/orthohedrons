<?php

namespace Tests;

use Ginsen\Orthohedrons\Cuboid;
use Ginsen\Orthohedrons\Axis;
use Ginsen\Orthohedrons\IAxis;
use Ginsen\Orthohedrons\ICuboid;
use PHPUnit\Framework\TestCase;

/**
 * Class CuboidTest
 * @package Tests
 */
class CuboidTest extends TestCase
{
    /**
     * @test
     */
    public function itIsInstanceOfICuboid(): void
    {
        $cuboid = new Cuboid(
            new Axis(0, 4),
            new Axis(0, 4),
            new Axis(0, 4)
        );

        $this->assertInstanceOf(ICuboid::class, $cuboid);
    }


    /**
     * @test
     */
    public function itHasXYZAxisInstance(): void
    {
        $cuboid = new Cuboid(
            new Axis(0, 4),
            new Axis(0, 4),
            new Axis(0, 4)
        );

        $axisX = $cuboid->getAxisX();
        $axisY = $cuboid->getAxisY();
        $axisZ = $cuboid->getAxisZ();

        $this->assertInstanceOf(IAxis::class, $axisX);
        $this->assertInstanceOf(IAxis::class, $axisY);
        $this->assertInstanceOf(IAxis::class, $axisZ);
    }


    /**
     * @test
     */
    public function itHasXYZAxisValidValues(): void
    {
        $cuboid = new Cuboid(
            new Axis(0, 1),
            new Axis(2, 3),
            new Axis(4, 5)
        );

        $axisX = $cuboid->getAxisX();
        $axisY = $cuboid->getAxisY();
        $axisZ = $cuboid->getAxisZ();

        $this->assertEquals(0, $axisX->initPoint());
        $this->assertEquals(1, $axisX->endPoint());

        $this->assertEquals(2, $axisY->initPoint());
        $this->assertEquals(3, $axisY->endPoint());

        $this->assertEquals(4, $axisZ->initPoint());
        $this->assertEquals(5, $axisZ->endPoint());
    }


    /**
     * @test
     */
    public function itReturnVolumeOfCube(): void
    {
        $cuboid = new Cuboid(
            new Axis(0, 5),
            new Axis(0, 5),
            new Axis(0, 5)
        );

        $this->assertEquals(125, $cuboid->getVolume());
    }


    /**
     * @test
     */
    public function whenItDetectOtherCuboidIntersectedReturnTrue(): void
    {
        $cuboidOne = new Cuboid(
            new Axis(0, 5),
            new Axis(0, 5),
            new Axis(0, 5)
        );

        $cuboidTwo = new Cuboid(
            new Axis(3, 7),
            new Axis(0, 2),
            new Axis(0, 2)
        );

        $this->assertTrue($cuboidOne->isIntersected($cuboidTwo));
    }


    /**
     * @test
     */
    public function whenItNotDetectOtherCuboidIntersectedReturnFalse(): void
    {
        $cuboidOne = new Cuboid(
            new Axis(0, 5),
            new Axis(0, 5),
            new Axis(0, 5)
        );

        $cuboidTwo = new Cuboid(
            new Axis(5, 7),
            new Axis(0, 2),
            new Axis(0, 2)
        );

        $this->assertFalse($cuboidOne->isIntersected($cuboidTwo));
    }


    /**
     * @test
     */
    public function itReturnNewInstanceOfCuboidIntersected(): void
    {
        $cuboidOne = new Cuboid(
            new Axis(0, 5),
            new Axis(0, 5),
            new Axis(0, 5)
        );

        $cuboidTwo = new Cuboid(
            new Axis(3, 7),
            new Axis(0, 2),
            new Axis(0, 2)
        );

        $newCuboid = $cuboidOne->getCuboidIntersected($cuboidTwo);

        $this->assertInstanceOf(ICuboid::class, $newCuboid);
    }


    /**
     * @test
     */
    public function itReturnVolumeOfNewCuboidIntersected(): void
    {
        $cuboidOne = new Cuboid(
            new Axis(0, 5),
            new Axis(0, 5),
            new Axis(0, 5)
        );

        $cuboidTwo = new Cuboid(
            new Axis(3, 7),
            new Axis(0, 2),
            new Axis(0, 2)
        );

        $this->assertEquals(125, $cuboidOne->getVolume());
        $this->assertEquals(16, $cuboidTwo->getVolume());

        $newCuboid = $cuboidOne->getCuboidIntersected($cuboidTwo);

        $this->assertEquals(8, $newCuboid->getVolume());
    }
}
