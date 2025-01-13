<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyService
{
    // Сам источник странно себя ведет
    // по USD, может вернуть 1
    private string $apiUrl = 'https://api.exchangerate-api.com/v4/latest/';

    /**
     * @param string $toCurrency
     * @return float
     * @throws \Exception
     */
    public function getExchangeRate(string $toCurrency): float
    {
        // Если частые запросы то можно использовать кеш
        //$baseCurrency = 'RUB';
        //$cacheKey = "exc_rate_{$baseCurrency}_to_{$toCurrency}";
        //$rate = Cache::get($cacheKey);
        //if ($rate === null) {
        //Cache::put($cacheKey, $rate, now()->addHour());
        //}
        //return $rate;

        $response = Http::get($this->apiUrl . $toCurrency);

        if (!$response->ok()) {
            throw new \Exception('Ошибка получения курса валют.');
        }

        $data = $response->json();

        if (!isset($data['rates'][$toCurrency])) {
            throw new \Exception('Неверная валюта.');
        }

        return $data['rates'][$toCurrency];
    }

    /**
     * @param float $amount
     * @param string $toCurrency
     * @return float
     * @throws \Exception
     */
    public function convertAmount(float $amount, string $toCurrency): float
    {
        $rate = $this->getExchangeRate($toCurrency);
        return $amount * $rate;
    }
}
