<?php

namespace Tests;

use Ginsen\Orthohedrons\Axis;
use Ginsen\Orthohedrons\IAxis;
use PHPUnit\Framework\TestCase;

/**
 * Class AxisTest
 * @package Tests
 */
class AxisTest extends TestCase
{
    /**
     * @test
     */
    public function itIsInstanceOfIAxis(): void
    {
        $axis = new Axis(0, 4);

        $this->assertInstanceOf(IAxis::class, $axis);
    }


    /**
     * @test
     */
    public function itHasTwoPoint(): void
    {
        $axis = new Axis(1, 2);
        $this->assertEquals(1, $axis->initPoint());
        $this->assertEquals(2, $axis->endPoint());
    }


    /**
     * @test
     * @dataProvider dataProviderToCheckDistance
     *
     * @param int $initPoint
     * @param int $endPoint
     * @param int $expected
     */
    public function itCalcDistance(int $initPoint,int $endPoint,int $expected)
    {
        $axis = new Axis($initPoint, $endPoint);

        $this->assertEquals($expected, $axis->getDistance());
    }


    /**
     * @return array
     */
    public function dataProviderToCheckDistance(): array
    {
        return [
            [0, 3, 3],
            [-2, 3, 5],
            [2, -1, 3],
            [2, -5, 7],
            [-2, -4, 2],
            [3, 4, 1]
        ];
    }


    /**
     * @test
     * @dataProvider dataProviderToCheckIntersection
     *
     * @param IAxis $axis
     * @param IAxis $otherAxis
     * @param bool  $expected
     */
    public function itCalcIntersectionWithOtherAxis(IAxis $axis, IAxis $otherAxis, bool $expected): void
    {
        $this->assertEquals($expected, $axis->isIntersected($otherAxis));
    }


    /**
     * @return array
     */
    public function dataProviderToCheckIntersection(): array
    {
        return [
            [new Axis(0, 5), new Axis(0, 2), true],
            [new Axis(0, 5), new Axis(-2, 2), true],
            [new Axis(0, 5), new Axis(0, 6), true],
            [new Axis(0, 3), new Axis(3, 5), false],
            [new Axis(3, 5), new Axis(0, 3), false],
        ];
    }
}