<?php

namespace JeroenDesloovere\VCard\tests\LineWrapper;

use JeroenDesloovere\VCard\LineWrapper\UnicodeLineWrapper;

class UnicodeLineWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider setChunkLengthDataProvider
     * @param int $expected
     * @param int $chunkLength
     * @internal param $expectedLength
     */
    public function testSetChunkLength($expected, $chunkLength)
    {
        $wrapper = new UnicodeLineWrapper();
        $wrapper->setChunkLength($chunkLength);
        $this->assertEquals($expected, $wrapper->getChunkLength());
    }

    public function setChunkLengthDataProvider()
    {
        return [[1, 1], ['10', '10'], [50, 50]];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider setChunkLengthExceptionsDataProvider
     * @param mixed $illegalChunkLength illegal chunkLength value
     */
    public function testSetChunkLengthExceptions($illegalChunkLength)
    {
        $wrapper = new UnicodeLineWrapper();
        $wrapper->setChunkLength($illegalChunkLength);
    }

    public function setChunkLengthExceptionsDataProvider()
    {
        return [[-10], [0], [1.1], ['not numeric value']];
    }

    /**
     * @dataProvider prepareLineDataProvider
     * @param string $source
     * @param string $expected
     */
    public function testPrepareLine($source, $expected)
    {
        $wrapper = new UnicodeLineWrapper(73);
        $this->assertEquals($expected, $wrapper->prepareLine($source));
    }

    public function prepareLineDataProvider()
    {
        return [
            ['short string', 'short string'],
            [
                'Individual lines within the MIME text/directory Content Type body are delimited by the [RFC-822] line break, which is a CRLF sequence.',
                "Individual lines within the MIME text/directory Content Type body are del\r\n imited by the [RFC-822] line break, which is a CRLF sequence.",
            ],
            [
                'Печально я гляжу на наше поколенье! Его грядущее — иль пусто, иль темно, Меж тем, под бременем познанья и сомненья, В бездействии состарится оно.',
                "Печально я гляжу на наше поколенье! Его \r\n грядущее — иль пусто, иль темно, Меж тем\r\n , под бременем познанья и сомненья, В бе\r\n здействии состарится оно.",
            ]
        ];
    }
}