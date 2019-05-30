<?php

namespace Yandex\Translate;

/**
 * Translate
 * @author Nikita Gusakov <dev@nkt.me>
 * @link   http://api.yandex.com/translate/doc/dg/reference/translate.xml
 */
class Translator
{
    const BASE_URL = 'https://translate.yandex.net/api/v1.5/tr.json/';
    const MESSAGE_UNKNOWN_ERROR = 'Unknown error';
    const MESSAGE_JSON_ERROR = 'JSON parse error';
    const MESSAGE_INVALID_RESPONSE = 'Invalid response from service';

    protected $key;

    protected $handler;

    public function __construct()
    {
        $this->key = 'trnsl.1.1.20190528T122613Z.43cd66fe27236856.af13ffe99bfc5149dc0be36268415b49c45196f9';
        $this->handler = curl_init();
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
    }

    public function detect($text)
    {
        $data = $this->execute('detect', array(
            'text' => $text
        ));

        return $data['lang'];
    }

    public function translate($text, $language, $html = false, $options = 0)
    {
        $data = $this->execute('translate', array(
            'text'    => $text,
            'lang'    => $language,
            'format'  => $html ? 'html' : 'plain',
            'options' => $options
        ));

        return new Translation($text, $data['text'], $data['lang']);
    }

    public function getSupportedLanguages()
    {
        $data = $this->execute('getLangs',array(
            'ui'=>'pl'
        ));
        return $data['langs'];
    }

    protected function execute($uri, array $parameters)
    {
        $parameters['key'] = $this->key;
        $url = static::BASE_URL . $uri . '?' . http_build_query($parameters);
        curl_setopt($this->handler, CURLOPT_URL, $url);
        
        $remoteResult = curl_exec($this->handler);
        if ($remoteResult === false) {
            throw new Exception(curl_error($this->handler), curl_errno($this->handler));
        }

        $result = json_decode($remoteResult, true);
        if (!$result) {
            $errorMessage = self::MESSAGE_UNKNOWN_ERROR;
            if (version_compare(PHP_VERSION, '5.3', '>=')) {
                if (json_last_error() !== JSON_ERROR_NONE) {
                    if (version_compare(PHP_VERSION, '5.5', '>=')) {
                        $errorMessage = json_last_error_msg();
                    } else {
                        $errorMessage = self::MESSAGE_JSON_ERROR;
                    }
                }
            }
            throw new Exception(sprintf('%s: %s', self::MESSAGE_INVALID_RESPONSE, $errorMessage));
        } elseif (isset($result['code']) && $result['code'] > 200) {
            throw new Exception($result['message'], $result['code']);
        }

        return $result;
    }
}
