<?php

namespace KmeCnin\Toolbox\LifeTimeBehaviour\Example;

use KmeCnin\Toolbox\LifeTimeBehaviour\Model\HasLifeTimeInterface;
use KmeCnin\Toolbox\LifeTimeBehaviour\Model\LifeTime;
use KmeCnin\Toolbox\LifeTimeBehaviour\Model\LifeTimeInterface;

final class Card implements HasLifeTimeInterface
{
    /**
     * @var LifeTimeInterface
     */
    protected $lifeTime;

    /**
     * {@inheritdoc}
     */
    public function setLifeTime($date = null)
    {
        $this->lifeTime = new LifeTime($date);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLifeTime()
    {
        return (null === $this->lifeTime)
            ? new LifeTime(null)
            : $this->lifeTime;
    }
}
