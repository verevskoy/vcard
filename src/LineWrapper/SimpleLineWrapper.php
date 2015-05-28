<?php

namespace JeroenDesloovere\VCard\LineWrapper;

class SimpleLineWrapper implements LineWrapperInterface
{
    /**
     * Fold a line according to RFC2425 section 5.8.1.
     *
     * @link http://tools.ietf.org/html/rfc2425#section-5.8.1
     * @param string $text
     * @return string
     */
    public function prepareLine($text)
    {
        if (strlen($text) <= 75) {
            return $text;
        }

        // split, wrap and trim trailing separator
        return substr(chunk_split($text, 73, "\r\n "), 0, -3);
    }
}