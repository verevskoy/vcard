<?php

namespace JeroenDesloovere\VCard\LineWrapper;

/**
 * Class UnicodeLineWrapper
 * @package JeroenDesloovere\VCard\LineWrapper
 */
class UnicodeLineWrapper implements LineWrapperInterface
{
    /**
     * @var int
     */
    private $chunkLength;

    public function __construct($chunkLength = 75)
    {
        $this->setChunkLength($chunkLength);
    }

    /**
     * @return int
     */
    public function getChunkLength()
    {
        return $this->chunkLength;
    }

    /**
     * @param int $chunkLength
     *
     * @return UnicodeLineWrapper
     * @throws \InvalidArgumentException
     */
    public function setChunkLength($chunkLength)
    {
        if (!is_integer($chunkLength * 1) || $chunkLength < 1) {
            throw new \InvalidArgumentException(sprintf('expected positive integer value. got "%s"', $chunkLength));
        }
        $this->chunkLength = $chunkLength;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepareLine($text)
    {
        if (strlen($text) <= $this->getChunkLength()) {
            return $text;
        }

        $chunks = [];
        $chunk = '';
        $amountOfSymbols = mb_strlen($text);
        for ($i = 0; $i < $amountOfSymbols; $i++) {
            $symbol = mb_substr($text, $i, 1);
            if (strlen($chunk) + strlen($symbol) > $this->getChunkLength()) {
                $chunks[] = $chunk;
                $chunk = ' ';
            }
            $chunk .= $symbol;
        }
        if (strlen($chunk) > 1) {
            $chunks[] = $chunk;
        }

        return implode($chunks, "\r\n");
    }
}