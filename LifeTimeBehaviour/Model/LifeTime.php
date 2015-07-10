<?php

namespace KmeCnin\Toolbox\LifeTimeBehaviour\Model;

class LifeTime implements LifeTimeInterface
{
    /**
     * @var \DateTime|null
     */
    protected $expiresAt;

    public function __construct($expiresAt = null)
    {
        $this->setExpiresAt($expiresAt);
    }

    /**
     * {@inheritdoc}
     */
    public function setExpiresAt($date)
    {
        $this->expiresAt = $date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired()
    {
        return $this->itWillExpiresAt(new \DateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function hasExpirationDate()
    {
        return null !== $this->expiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function itWillExpiresAt(\DateTime $date)
    {
        return (null === $this->expiresAt)
            ? false // card will never be expired
            : $this->expiresAt < $date; // test expired date against given date
    }
}
