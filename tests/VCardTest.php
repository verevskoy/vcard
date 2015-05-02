<?php

namespace JeroenDesloovere\VCard\tests;

// required to load
require_once __DIR__ . '/../vendor/autoload.php';

/*
 * This file is part of the VCard PHP Class from Jeroen Desloovere.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\VCard\VCard;

/**
 * This class will test our VCard PHP Class which can generate VCards.
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class VCardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up before class
     *
     * @return SocialMedia
     */
    public function setUp()
    {
        $this->vcard = new VCard();

        $this->firstName = 'Jeroen';
        $this->lastName = 'Desloovere';
        $this->additional = '&';
        $this->prefix = 'Mister';
        $this->suffix = 'Junior';

        $this->firstName2 = 'Ali';
        $this->lastName2 = 'ÖZSÜT';

        $this->firstName3 = 'Garçon';
        $this->lastName3 = 'Jéroèn';
    }

    /**
     * Tear down after class
     */
    public function tearDown()
    {
        $this->vcard = null;
    }

    /**
     * Test first name and last name
     */
    public function testFirstNameAndLastName()
    {
        $this->vcard->addName(
            $this->lastName,
            $this->firstName
        );

        $this->assertEquals('jeroen-desloovere', $this->vcard->getFilename());
    }

    /**
     * Test special first name and last name
     */
    public function testSpecialFirstNameAndLastName()
    {
        $this->vcard->addName(
            $this->lastName2,
            $this->firstName2
        );

        $this->assertEquals('ali-ozsut', $this->vcard->getFilename());
    }

    /**
     * Test special first name and last name
     */
    public function testSpecialFirstNameAndLastName2()
    {
        $this->vcard->addName(
            $this->lastName3,
            $this->firstName3
        );

        $this->assertEquals('garcon-jeroen', $this->vcard->getFilename());
    }

    /**
     * Test full blown name
     */
    public function testFullBlownName()
    {
        $this->vcard->addName(
            $this->lastName,
            $this->firstName,
            $this->additional,
            $this->prefix,
            $this->suffix
        );

        $this->assertEquals('mister-jeroen-desloovere-junior', $this->vcard->getFilename());
    }

    /**
     * @dataProvider _testFoldDataProvider
     * @param string $foldText
     * @param string $expected
     */
    public function testFold($foldText, $expected)
    {
        //mbstring.func_overload must be >= 2
        $vCard = new VCard();
        $reflection = new \ReflectionClass(get_class($vCard));
        $method = $reflection->getMethod('fold');
        $method->setAccessible(true);
        $this->assertEquals($expected, $method->invokeArgs($vCard, [$foldText]));
    }

    public function _testFoldDataProvider()
    {
        return [
            ['short string', 'short string'],
            [
                //russian language
                "NOTE:Ветер, ветер! Ты могуч, Ты гоняешь стаи туч, Ты волнуешь сине море, Всюду веешь на просторе. Не боишься никого, Кроме бога одного.",
                "NOTE:Ветер, ветер! Ты могуч, Ты гоняешь стаи туч, Ты волнуешь сине море, \r\n Всюду веешь на просторе. Не боишься никого, Кроме бога одного.",
            ]
        ];
    }
}
