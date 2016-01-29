<?php

namespace app\tools\converter;

class CurrencyConverter implements ConverterInterface
{
    const CURRENCY_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';
    /**
     * Валюта, в которой приходит запрос в конвертер
     */
    const INPUT_VALUTE = 'USD';
    /**
     * Валюта, в которой приходят данные от ЦБ (xml)
     */
    const HOME_VALUTE = 'RUB';

    private $data;
    private $cache;

    public function __construct($params, $cacheConfig = array())
    {
        $this->data = $params;
        if (array_key_exists('host', $cacheConfig)) {
            $this->cache = new \Memcached;
            $this->cache->addServer($cacheConfig['host'], $cacheConfig['port']);
        }
    }

    public function get()
    {
        $params = $this->data;
        $currencies = $this->getCurrencies();

        if ($this->validate()) {
            $outCurrency = strtoupper($params['currency']);
            if (!isset($currencies[$outCurrency])) {
                throw new ConverterException(ConverterException::$messages[ConverterException::NO_CURRENCY]);
            }
            return array(
                'cost' => $params['cost'] * $currencies[$outCurrency],
                'currency' => $params['currency']
            );
        }

        throw new ConverterException(ConverterException::$messages[ConverterException::NO_ATTRIBUTE]);
    }

    public function validate()
    {
        foreach ($this->required() as $key) {
            if (!isset($this->data[$key])) {
                return false;
            }
        }
        return true;
    }

    public function required()
    {
        return array('cost', 'currency');
    }

    private function getCurrencies()
    {
        if ($this->cache instanceof \Memcached) {
            $currencies = $this->cache->get('converter_cr');
            if ($currencies === false) {
                $currencies = $this->downloadCurrencies();
                $this->cache->set('converter_cr', $currencies, 60);
            }
            return $currencies;
        }
        return $this->downloadCurrencies();
    }

    private function downloadCurrencies()
    {
        $xml = $this->download();
        return $this->prepare($xml);
    }

    private function download()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::CURRENCY_URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec($ch);
    }

    /**
     * Возвращает массив коэффициентов (множителей) относительно INPUT_VALUTE
     * @param $xml
     * @return array
     */
    private function prepare($xml)
    {
        $base = new \SimpleXMLElement($xml);

        $coeffs = array();
        foreach ($base->Valute as $valute) {
            $key = (string) $valute->CharCode;
            $coeffs[$key] = str_replace(',', '.', (string) $valute->Value) / (string) $valute->Nominal;
        }
        $rub = (float) $coeffs[self::INPUT_VALUTE];
        $coeffs = array_map(function($value) use($rub) {
            return round($rub / $value, 4);
        }, $coeffs);
        $coeffs[self::HOME_VALUTE] = $rub;

        return $coeffs;
    }

}