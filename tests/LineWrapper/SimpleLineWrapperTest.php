<?php

namespace JeroenDesloovere\VCard\tests\LineWrapper;

use JeroenDesloovere\VCard\LineWrapper\SimpleLineWrapper;

class SimpleLineWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider prepareLineDataProvider
     * @param string $source
     * @param string $expected
     */
    public function testPrepareLine($source, $expected)
    {
        $wrapper = new SimpleLineWrapper();
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
        ];
    }
}