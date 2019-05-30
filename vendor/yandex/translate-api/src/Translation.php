<?php

namespace Yandex\Translate;

/**
 * Translation
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Translation
{
    
    protected $source;

    protected $result;

    protected $language;

    public function __construct($source, $result, $language)
    {
        $this->source = $source;
        $this->result = $result;
        $this->language = explode('-', $language);
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getSourceLanguage()
    {
        return $this->language[0];
    }

    public function getResultLanguage()
    {
        return $this->language[1];
    }

    public function __toString()
    {
        if (is_array($this->result)) {
            return join(' ', $this->result);
        }

        return (string) $this->result;
    }
}
