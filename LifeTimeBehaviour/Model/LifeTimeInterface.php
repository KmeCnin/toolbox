<?php

namespace KmeCnin\Toolbox\LifeTimeBehaviour\Model;

interface LifeTimeInterface
{
    /**
     * Set expiresAt.
     *
     * @param \DateTime
     *
     * @return LifeTimeInterface
     */
    public function setExpiresAt($date);

    /**
     * Get expiresDate or null if undefined.
     *
     * @return \DateTime|null
     */
    public function getExpiresAt();

    /**
     * Test if it is expired.
     *
     * @return bool
     */
    public function isExpired();

    /**
     * Test if it will expires at the given date.
     *
     * @return bool
     */
    public function itWillExpiresAt(\DateTime $date);

    /**
     * Test if it should expires.
     *
     * @return bool
     */
    public function hasExpirationDate();
}
