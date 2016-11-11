<?php
/**
 * XMLWriter 易用性封裝
 */
class MXMLWriter extends XMLWriter
{
    public function writeElementCData($element, $value)
    {
        $this->startElement($element);
        $this->writeCData($value);
        $this->endElement();
    }
}
