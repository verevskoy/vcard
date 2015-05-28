<?php

namespace JeroenDesloovere\VCard\LineWrapper;

interface LineWrapperInterface
{
    /**
     * Prepare a line
     *
     * @param string $text
     * @return string
     */
    public function prepareLine($text);
}