<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handleMessage(Request $request)
    {
        $message = $request->input('message');

        if (!$message) {
            return response()->json(['reply' => 'Bạn chưa nhập nội dung.'], 400);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model'    => 'gpt-3.5-turbo', // ✅ model rẻ nhất
                'messages' => [
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens'  => 300,
            ]);

            Log::info('OpenAI raw response: ' . $response->body());

            if ($response->failed()) {
                Log::error('OpenAI API lỗi: ' . $response->body());
                return response()->json(['reply' => 'OpenAI gặp lỗi, thử lại sau.'], 500);
            }

            $data = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? 'Tôi không hiểu.';

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            Log::error('OpenAI Exception: ' . $e->getMessage());
            return response()->json(['reply' => 'Lỗi server OpenAI.'], 500);
        }
    }
}
