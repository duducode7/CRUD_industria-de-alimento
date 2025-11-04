<?php
// zenquotes.php

function getZenQuote($useCache = true) {
    // caminho do cache local (opcional)
    $cacheFile = __DIR__ . '/zenquote_cache.json';
    $cacheTtl = 60 * 10; // 10 minutos

    // tentar cache primeiro
    if ($useCache && file_exists($cacheFile)) {
        $meta = json_decode(file_get_contents($cacheFile), true);
        if ($meta && (time() - $meta['fetched_at'] < $cacheTtl) && !empty($meta['quote'])) {
            return $meta['quote'];
        }
    }

    $url = "https://zenquotes.io/api/random";

    // cURL com timeout e tratamento de erro
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_FAILONERROR => true,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $result = curl_exec($ch);
    $err = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // fallback em caso de erro
    $fallback = [
        'q' => 'Mantenha o foco e continue avançando!',
        'a' => 'Equipe'
    ];

    if ($err || $httpCode >= 400 || !$result) {
        return $fallback;
    }

    $data = json_decode($result, true);
    if (!is_array($data) || empty($data[0]['q'])) {
        return $fallback;
    }

    $quote = [
        'q' => $data[0]['q'],
        'a' => $data[0]['a']
    ];

    // salvar cache
    if ($useCache) {
        file_put_contents($cacheFile, json_encode([
            'fetched_at' => time(),
            'quote' => $quote
        ]));
    }

    return $quote;
}
