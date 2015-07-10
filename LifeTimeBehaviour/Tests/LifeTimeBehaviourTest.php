<?php

namespace KmeCnin\Toolbox\LifeTimeBehaviour\Tests;

use KmeCnin\Toolbox\LifeTimeBehaviour\Example\Card;

class LifeTimeBehaviourTest extends \PHPUnit_Framework_TestCase
{
    public static function cardsIsExpiredProvider()
    {
        $today = new \DateTime('now -1 hour');
        $tomorrow = new \DateTime('tomorrow');
        $yesterday = new \DateTime('yesterday');
        $originOfTime = new \DateTime('1/1/1');
        $endOfTime = new \DateTime('1/1/9999');
        return array(
            // This cards should be expired :
            array($today, true),
            array($yesterday, true),
            array($originOfTime, true),
            // This cards should not be expired :
            array(null, false),
            array($tomorrow, false),
            array($endOfTime, false),
        );
    }

    /**
     * Test if given parameters match given expected result
     *
     * @param \DateTime $expiresAt
     * @param bool $shouldBeExpired
     *
     * @dataProvider cardsIsExpiredProvider
     */
    public function testIsExpired($expiresAt, $shouldBeExpired)
    {
        $card = new Card();
        $card->setLifeTime($expiresAt);
        $this->assertTrue($shouldBeExpired === $card->getLifeTime()->isExpired());
        $this->assertTrue($shouldBeExpired === $card->getLifeTime()->itWillExpiresAt(new \DateTime()));
    }

    /**
     * Test if hasExpirationDate
     */
    public function testHasExpirationDate()
    {
        $card = new Card();
        $card->setLifeTime(null);
        $this->assertNotTrue($card->getLifeTime()->hasExpirationDate());

        $card = new Card();
        $this->assertNotTrue($card->getLifeTime()->hasExpirationDate());

        $card = new Card();
        $card->setLifeTime(new \DateTime());
        $this->assertTrue($card->getLifeTime()->hasExpirationDate());
    }

    /**
     * Test that we can toggle expirable/not expirable
     */
    public function testToggleExpirable()
    {
        $card = new Card();
        // Not expirable
        $card->setLifeTime(null);
        $this->assertNotTrue($card->getLifeTime()->hasExpirationDate());
        // Expirable
        $card->setLifeTime(new \DateTime());
        $this->assertTrue($card->getLifeTime()->hasExpirationDate());
        // Not expirable again
        $card->setLifeTime(null);
        $this->assertNotTrue($card->getLifeTime()->hasExpirationDate());
    }
}