<?php

namespace Ginsen\Orthohedrons;

/**
 * Interface ICuboid
 * @package Ginsen\Orthohedrons
 */
interface ICuboid
{
    /**
     * @return IAxis
     */
    public function getAxisX(): IAxis;

    /**
     * @return IAxis
     */
    public function getAxisY(): IAxis;

    /**
     * @return IAxis
     */
    public function getAxisZ(): IAxis;

    /**
     * @return int
     */
    public function getVolume(): int;

    /**
     * @param ICuboid $cuboid
     * @return bool
     */
    public function isIntersected(ICuboid $cuboid): bool;

    /**
     * @param ICuboid $cuboid
     * @return ICuboid|null
     */
    public function getCuboidIntersected(ICuboid $cuboid): ?ICuboid;
}