<?php

namespace App\Libraries;

use Config\Services;
use Exception;

class GeminiService
{
    private const API_BASE_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
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
            $response = $this->makeApiRequest($title, $content);
            $tagsString = $this->extractTagsFromResponse($response);
            return $this->parseTags($tagsString);
        } catch (Exception $e) {
            log_message('error', '[GeminiService] ' . $e->getMessage());
            return [];
        }
    }

    private function validateApiKey(): bool
    {
        if (empty($this->apiKey)) {
            log_message('error', '[GeminiService] GEMINI_API_KEY is not set.');
            return false;
        }
        return true;
    }

    private function makeApiRequest(string $title, string $content): array
    {
        $url = $this->buildApiUrl();
        $payload = $this->buildRequestPayload($title, $content);

        $response = $this->httpClient->post($url, [
            'json' => $payload,
            'timeout' => 30,
        ]);

        return json_decode($response->getBody(), true) ?? [];
    }

    private function buildApiUrl(): string
    {
        return self::API_BASE_URL . "?key={$this->apiKey}";
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
            "Berikan 10 tag singkat yang relevan, dipisahkan dengan koma, untuk berita dengan judul berikut: \"%s\" dan konten berikut: \"%s\". Pastikan tag tersebut umum digunakan dalam konteks berita di Indonesia.",
            $title,
            $content
        );
    }

    private function extractTagsFromResponse(array $response): string
    {
        if (empty($response['candidates'][0]['content']['parts'][0]['text'])) {
            log_message('warning', '[GeminiService] Empty or unexpected response: ' . json_encode($response));
            throw new Exception('Invalid API response format');
        }

        return $response['candidates'][0]['content']['parts'][0]['text'];
    }

    private function parseTags(string $tagsString): array
    {
        $tags = array_filter(array_map('trim', explode(',', $tagsString)));
        return array_values($tags); // Reindex array
    }
}
