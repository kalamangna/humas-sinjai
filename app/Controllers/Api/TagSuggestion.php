<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\GeminiService;

class TagSuggestion extends ResourceController
{
    public function suggest()
    {
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        if (empty($title) || empty($content)) {
            return $this->fail('Title and content are required.', 400);
        }

        $geminiService = new GeminiService();
        $suggestedTags = $geminiService->suggestTags($title, $content);

        return $this->respond($suggestedTags);
    }
}
