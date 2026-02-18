<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    /**
     * Generate email content using ChatGPT
     */
    public function generateEmail(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4.1-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a professional email copywriter for automotive dealerships. Create engaging, professional email templates in HTML format. Use merge fields like @{{ first_name }}, @{{ dealer_name }}, @{{ vehicle_year }}, etc. Keep emails concise and focused.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Create an email template for: {$request->description}. Return ONLY the HTML body content (no <html>, <body> tags), properly formatted with paragraphs. Include a subject line suggestion at the end marked with 'SUBJECT:'"
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Extract subject if present
                $subject = '';
                if (preg_match('/SUBJECT:\s*(.+)$/im', $content, $matches)) {
                    $subject = trim($matches[1]);
                    $content = preg_replace('/SUBJECT:\s*.+$/im', '', $content);
                }
                
                $content = trim($content);

                return response()->json([
                    'success' => true,
                    'content' => $content,
                    'subject' => $subject,
                ]);
            }

            Log::error('OpenAI API Error', ['response' => $response->body()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate email content'
            ], 500);

        } catch (\Exception $e) {
            Log::error('AI Generate Email Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate subject lines using ChatGPT
     */
    public function generateSubjects(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:500',
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert email marketer for automotive dealerships. Create compelling, short subject lines that drive opens. Use merge fields like @{{ first_name }}, @{{ dealer_name }} where appropriate.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Generate 3 different subject lines for an email about: {$request->description}. Return ONLY the subject lines, one per line, no numbering or extra text."
                        ]
                    ],
                    'temperature' => 0.8,
                    'max_tokens' => 200,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Split by newlines and clean up
                $subjects = array_filter(
                    array_map('trim', explode("\n", $content)),
                    function($line) {
                        return !empty($line) && strlen($line) > 5;
                    }
                );
                
                // Remove numbering if present (e.g., "1. ", "- ", etc.)
                $subjects = array_map(function($subject) {
                    return preg_replace('/^[\d\-\*\.]+\s*/', '', $subject);
                }, $subjects);

                // Ensure we have at least 3 subjects
                $subjects = array_slice(array_values($subjects), 0, 3);

                return response()->json([
                    'success' => true,
                    'subjects' => $subjects,
                ]);
            }

            Log::error('OpenAI API Error (Subjects)', ['response' => $response->body()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate subject lines'
            ], 500);

        } catch (\Exception $e) {
            Log::error('AI Generate Subjects Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate image using DALL-E
     */
    public function generateImage(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:500',
        ]);

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/images/generations', [
                    'model' => 'dall-e-3',
                    'prompt' => $request->description . ' - Professional, high quality, suitable for automotive dealership marketing email',
                    'n' => 1,
                    'size' => '1024x1024',
                    'quality' => 'standard',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['data'][0]['url'] ?? null;

                if ($imageUrl) {
                    // Optionally download and store the image
                    // For now, just return the URL
                    return response()->json([
                        'success' => true,
                        'image_url' => $imageUrl,
                    ]);
                }
            }

            Log::error('OpenAI DALL-E API Error', ['response' => $response->body()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate image'
            ], 500);

        } catch (\Exception $e) {
            Log::error('AI Generate Image Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}