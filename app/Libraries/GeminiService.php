<?php

namespace App\Libraries;

use Config\Services;
use Exception;

class GeminiService
{
    private const BASE_URL = 'https://generativelanguage.googleapis.com/v1beta/models/';
    private const PRIMARY_MODEL = 'gemini-2.5-flash';
    private const FALLBACK_MODEL = 'gemini-2.5-flash-lite';
    private const MAX_CONTENT_LENGTH = 500;

    private string $apiKey;
    private $httpClient;

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? getenv('GEMINI_API_KEY') ?? '';
        $this->httpClient = Services::curlrequest();
    }

    public function suggestTags(string $title, string $content): array
    {
        if (!$this->validateApiKey()) {
            return [];
        }

        try {
            return $this->attemptSuggestion($title, $content, self::PRIMARY_MODEL);
        } catch (Exception $e) {
            log_message('warning', "[GeminiService] Primary model (" . self::PRIMARY_MODEL . ") failed: " . $e->getMessage() . ". Switching to fallback model (" . self::FALLBACK_MODEL . ").");

            try {
                return $this->attemptSuggestion($title, $content, self::FALLBACK_MODEL);
            } catch (Exception $e2) {
                log_message('error', '[GeminiService] Fallback model also failed: ' . $e2->getMessage());
                return [];
            }
        }
    }

    private function attemptSuggestion(string $title, string $content, string $model): array
    {
        $response = $this->makeApiRequest($title, $content, $model);
        $tagsString = $this->extractTagsFromResponse($response);
        return $this->parseTags($tagsString);
    }

    private function validateApiKey(): bool
    {
        if (empty($this->apiKey)) {
            log_message('error', '[GeminiService] GEMINI_API_KEY is not set.');
            return false;
        }
        return true;
    }

    private function makeApiRequest(string $title, string $content, string $model): array
    {
        $url = $this->buildApiUrl($model);
        $payload = $this->buildRequestPayload($title, $content);

        // We do not catch exceptions here; we let them bubble up to suggestTags
        // so it can trigger the fallback logic.
        $response = $this->httpClient->post($url, [
            'json' => $payload,
            'timeout' => 30,
            'http_errors' => true // Ensure 4xx/5xx responses throw exceptions
        ]);

        return json_decode($response->getBody(), true) ?? [];
    }

    private function buildApiUrl(string $model): string
    {
        return self::BASE_URL . $model . ":generateContent?key=".$this->apiKey;
    }

    private function buildRequestPayload(string $title, string $content): array
    {
        $cleanedContent = $this->prepareContent($content);
        $prompt = $this->buildPrompt($title, $cleanedContent);

        return [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
    }

    private function prepareContent(string $content): string
    {
        $strippedContent = strip_tags($content);
        return substr($strippedContent, 0, self::MAX_CONTENT_LENGTH);
    }

    private function buildPrompt(string $title, string $content): string
    {
        return sprintf(
            "Berdasarkan judul dan konten berita di bawah ini, hasilkan 10 tag SEO singkat dan relevan.

            Aturan:
            - Tampilkan hanya daftar tag, pisahkan dengan koma.
            - Jangan berikan penjelasan, pengantar, atau kalimat tambahan.
            - Jangan beri nomor atau bullet.
            - Gunakan kata atau frasa pendek yang umum dipakai di berita Indonesia.
            - Mulai langsung dari daftar tag, tanpa teks lain.

            Judul: \"%s\"
            Konten: \"%s\"",
            $title,
            $content
        );
    }

    private function extractTagsFromResponse(array $response): string
    {
        if (empty($response['candidates'][0]['content']['parts'][0]['text'])) {
            log_message('warning', '[GeminiService] Empty or unexpected response: ' . json_encode($response));
            throw new Exception('Invalid API response format or blocked content');
        }

        return $response['candidates'][0]['content']['parts'][0]['text'];
    }

    private function parseTags(string $tagsString): array
    {
        $tags = array_filter(array_map('trim', explode(',', $tagsString)));
        return array_values($tags); // Reindex array
    }
}