<?php

namespace KmeCnin\Toolbox\LifeTimeBehaviour\Model;

interface HasLifeTimeInterface
{
    /**
     * Set LifeTime.
     *
     * @param \DateTime|null
     *
     * @return HasLifeTimeInterface
     */
    public function setLifeTime($lifeTime);

    /**
     * Get LifeTime.
     *
     * @return LifeTimeInterface
     */
    public function getLifeTime();
}
