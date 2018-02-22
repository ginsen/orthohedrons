<?php
namespace Ginsen\Orthohedrons;

/**
 * Interface IAxis
 * @package Ginsen\Orthohedrons
 */
interface IAxis
{
    /**
     * @return int
     */
    public function initPoint(): int;

    /**
     * @return int
     */
    public function endPoint(): int;

    /**
     * @return int
     */
    public function getDistance(): int;

    /**
     * @param IAxis $axis
     * @return IAxis
     */
    public function getIntersectedAxis(IAxis $axis): IAxis;

    /**
     * @param IAxis $axis
     * @return bool
     */
    public function isIntersected(IAxis $axis): bool;
}
