<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ChatboxController extends Controller
{
    public function index()
    {
        $aiStatus = $this->checkAIStatus();
        return view('user.chatbox.index', compact('aiStatus'));
    }

    private function checkAIStatus()
    {
        $apiKey = env('GEMINI_API_KEY');
        return [
            'gemini_enabled' => $apiKey && $apiKey !== 'your_gemini_api_key_here',
            'ai_model' => $apiKey && $apiKey !== 'your_gemini_api_key_here' ? 'Google Gemini AI' : 'Rule-based System'
        ];
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->input('message');

        // Tích hợp AI chatbot response đơn giản
        $botResponse = $this->generateAIResponse($userMessage);

        return response()->json([
            'success' => true,
            'user_message' => $userMessage,
            'bot_response' => $botResponse,
            'timestamp' => now()->format('H:i')
        ]);
    }

    private function generateAIResponse($message)
    {
        // Nếu không có API key hợp lệ thì dùng fallback ngay lập tức
        $apiKey = env('GEMINI_API_KEY');
        // if (!$apiKey || $apiKey === 'your_gemini_api_key_here') {
        //     return $this->generateFallbackResponse($message);
        // }

        // Nếu có API key: thử gọi Gemini với một số lần retry và CHẮC CHẮN không dùng fallback.
        $maxAttempts = 5;
        $attempt = 0;
        $lastException = null;

        while ($attempt < $maxAttempts) {
            $attempt++;
            try {
                $geminiResponse = $this->callGeminiAPI($message);

                if ($geminiResponse) {
                    return $geminiResponse;
                }

                // Nếu không có nội dung trả về, đợi 1 giây rồi thử lại
                sleep(1);
            } catch (\Exception $e) {
                Log::warning("Gemini API attempt {$attempt} failed: " . $e->getMessage());
                $lastException = $e;
                // đợi một chút trước khi thử lại
                sleep(1);
            }
        }

        // Sau khi thử nhiều lần mà vẫn không có phản hồi, không dùng fallback theo yêu cầu.
        Log::error('Gemini API unreachable after ' . $maxAttempts . ' attempts. Last error: ' . ($lastException ? $lastException->getMessage() : 'no response'));

        // Trả về một thông báo rõ ràng cho front-end rằng AI tạm thời không khả dụng.
        return 'Xin lỗi, trợ lý AI tạm thời không sẵn sàng. Vui lòng thử lại sau vài phút.';
    }

    private function callGeminiAPI($message)
    {
        $apiKey = trim((string) env('GEMINI_API_KEY', ''));
        $apiUrl = trim((string) env('GEMINI_API_URL', ''));

        if (!$apiKey || $apiKey === 'your_gemini_api_key_here') {
            return null; // API key not configured
        }

        // Configure Guzzle client: prefer explicit CA bundle if provided, otherwise
        // fall back to disabling verification to allow quick local testing.
        $clientOptions = [];

        // If user provided a GEMINI_CACERT_PATH in .env, use it for verify.
        $cacert = trim((string) env('GEMINI_CACERT_PATH', ''));
        if ($cacert !== '') {
            $clientOptions['verify'] = $cacert;
        } else {
            // WARNING: false disables SSL verification — use only for local testing.
            $clientOptions['verify'] = false;
        }

        // Optionally set base_uri to API root so we can post relative paths later.
        try {
            $parsed = parse_url($apiUrl);
            if ($parsed && isset($parsed['scheme']) && isset($parsed['host'])) {
                $base = $parsed['scheme'] . '://' . $parsed['host'];
                if (isset($parsed['port'])) {
                    $base .= ':' . $parsed['port'];
                }
                if (isset($parsed['path'])) {
                    // keep up to /v1beta/ if present
                    if (strpos($parsed['path'], '/v1beta') !== false) {
                        $base .= substr($parsed['path'], 0, strpos($parsed['path'], '/v1beta') + 7);
                    }
                }
                $clientOptions['base_uri'] = $base;
            }
        } catch (\Exception $e) {
            // ignore parsing errors and proceed without base_uri
        }

        $client = new Client($clientOptions);

        // Tạo system prompt chuyên về trang sức
        $systemPrompt = "Bạn là trợ lý AI chuyên nghiệp của Jewelry Shop - cửa hàng trang sức cao cấp. 
        Nhiệm vụ của bạn là tư vấn khách hàng về:
        - Các loại trang sức: nhẫn, dây chuyền, vòng tay, bông tai
        - Chất liệu: vàng, bạc, kim cương, đá quý
        - Giá cả và chính sách bảo hành
        - Tư vấn lựa chọn phù hợp với từng dịp và phong cách
        
        Hãy trả lời một cách thân thiện, chuyên nghiệp và hữu ích. 
        Độ dài phản hồi nên từ 1-3 câu, không quá dài.
        Luôn khuyến khích khách hàng xem sản phẩm trên website hoặc đến cửa hàng.";

        $fullMessage = $systemPrompt . "\n\nKhách hàng hỏi: " . $message;

        try {
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $fullMessage
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 200,
                ]
            ];

            // Log request payload (safe in dev only)
            if (config('app.debug')) {
                Log::debug('Gemini request', ['url' => $apiUrl, 'headers' => ['X-goog-api-key' => $apiKey], 'payload' => $payload]);
            }

            $response = $client->post($apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey,
                ],
                'json' => $payload,
                'timeout' => 10
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Log response status and body when in debug
            if (config('app.debug')) {
                Log::debug('Gemini response', ['status' => $response->getStatusCode(), 'body' => $data]);
            }

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return trim($data['candidates'][0]['content']['parts'][0]['text']);
            }

            // If API returned non-standard structure, log raw data
            Log::warning('Gemini returned no candidates', ['response' => $data]);
            return null;
        } catch (\Exception $e) {
            // Try to capture response body if available
            if (isset($response) && method_exists($response, 'getBody')) {
                try {
                    $raw = $response->getBody()->getContents();
                    Log::error('Gemini API call failed: ' . $e->getMessage(), ['raw_response' => $raw]);
                } catch (\Exception $ex) {
                    Log::error('Gemini API call failed and could not read response body: ' . $ex->getMessage());
                }
            } else {
                Log::error('Gemini API call failed: ' . $e->getMessage());
            }
            return null;
        }
    }

    // private function generateFallbackResponse($message)
    // {
    //     // Chuyển tin nhắn về chữ thường để dễ xử lý
    //     $lowerMessage = strtolower($message);

    //     // Các từ khóa và phản hồi tương ứng
    //     $responses = [
    //         // Chào hỏi
    //         'chào|xin chào|hello|hi' => [
    //             'Xin chào! Tôi là trợ lý AI của Jewelry Shop. Tôi có thể giúp gì cho bạn hôm nay?',
    //             'Chào bạn! Tôi có thể tư vấn về trang sức, giá cả, hoặc trả lời các câu hỏi của bạn.',
    //             'Hello! Chào mừng bạn đến với Jewelry Shop. Bạn cần hỗ trợ gì không?'
    //         ],

    //         // Sản phẩm trang sức
    //         'nhẫn|nhẫn cưới|nhẫn kim cương' => [
    //             'Chúng tôi có nhiều loại nhẫn đẹp: nhẫn kim cương, nhẫn vàng, nhẫn bạc. Bạn quan tâm đến loại nào?',
    //             'Nhẫn của shop rất đa dạng về mẫu mã và chất liệu. Bạn có ngân sách dự kiến không?',
    //             'Nhẫn kim cương của chúng tôi được chế tác từ kim cương thiên nhiên cao cấp. Bạn muốn xem thêm không?'
    //         ],

    //         'dây chuyền|vòng cổ' => [
    //             'Dây chuyền của shop có nhiều kiểu dáng từ cổ điển đến hiện đại. Bạn thích phong cách nào?',
    //             'Chúng tôi có dây chuyền vàng, bạc và bạch kim với nhiều mẫu mã đẹp.',
    //             'Dây chuyền là món trang sức rất phù hợp làm quà tặng. Bạn mua để tặng ai không?'
    //         ],

    //         'vòng tay|lắc tay' => [
    //             'Vòng tay vàng của shop rất tinh xảo, được chế tác thủ công bởi các nghệ nhân lành nghề.',
    //             'Chúng tôi có vòng tay cho cả nam và nữ với nhiều chất liệu khác nhau.',
    //             'Vòng tay charm rất được ưa chuộng hiện nay. Bạn có muốn xem không?'
    //         ],

    //         'bông tai|khuyên tai' => [
    //             'Bông tai kim cương của shop rất lộng lẫy, phù hợp với các dịp quan trọng.',
    //             'Chúng tôi có bông tai từ đơn giản đến cầu kỳ, phù hợp mọi phong cách.',
    //             'Bông tai là điểm nhấn hoàn hảo cho gương mặt. Bạn thích kiểu nào?'
    //         ],

    //         // Giá cả
    //         'giá|giá cả|bao nhiêu tiền|chi phí' => [
    //             'Giá trang sức phụ thuộc vào chất liệu và thiết kế. Bạn có thể xem chi tiết trên website.',
    //             'Chúng tôi có sản phẩm từ 500k đến 50 triệu, phù hợp mọi ngân sách.',
    //             'Shop thường xuyên có khuyến mãi. Bạn có thể theo dõi để mua với giá tốt nhất.'
    //         ],

    //         // Chất liệu
    //         'vàng|kim cương|bạc|bạch kim' => [
    //             'Tất cả trang sức của shop đều được làm từ chất liệu cao cấp, có chứng nhận chất lượng.',
    //             'Chúng tôi cam kết 100% về chất lượng vàng, kim cương và các loại đá quý.',
    //             'Mỗi sản phẩm đều có giấy chứng nhận xuất xứ và chất lượng rõ ràng.'
    //         ],

    //         // Dịch vụ
    //         'bảo hành|đổi trả|giao hàng' => [
    //             'Shop bảo hành trọn đời cho trang sức, hỗ trợ vệ sinh và sửa chữa miễn phí.',
    //             'Chính sách đổi trả trong 30 ngày, giao hàng toàn quốc với bảo hiểm.',
    //             'Dịch vụ của shop rất chu đáo, bạn có thể yên tâm mua sắm.'
    //         ],

    //         // Tư vấn
    //         'tư vấn|chọn|lựa chọn|phù hợp' => [
    //             'Tôi có thể tư vấn trang sức phù hợp dựa trên sở thích và ngân sách của bạn.',
    //             'Hãy cho tôi biết bạn muốn mua trang sức cho dịp gì để tư vấn phù hợp nhất.',
    //             'Bạn có thể mô tả phong cách yêu thích để tôi gợi ý sản phẩm phù hợp.'
    //         ],

    //         // Cảm ơn, kết thúc
    //         'cảm ơn|thank you|thanks' => [
    //             'Không có gì! Rất vui được hỗ trợ bạn.',
    //             'Cảm ơn bạn đã quan tâm đến Jewelry Shop!',
    //             'Chúc bạn tìm được món trang sức ưng ý!'
    //         ],

    //         'tạm biệt|bye|goodbye' => [
    //             'Tạm biệt! Hẹn gặp lại bạn!',
    //             'Chúc bạn một ngày tốt lành!',
    //             'Bye bye! Nhớ quay lại shop nhé!'
    //         ]
    //     ];

    //     // Tìm phản hồi phù hợp
    //     foreach ($responses as $pattern => $responseList) {
    //         if (preg_match('/(' . $pattern . ')/i', $lowerMessage)) {
    //             return $responseList[array_rand($responseList)];
    //         }
    //     }

    //     // Phản hồi mặc định
    //     $defaultResponses = [
    //         'Tôi không hiểu rõ câu hỏi của bạn. Bạn có thể hỏi về trang sức, giá cả, hoặc dịch vụ của shop.',
    //         'Xin lỗi, tôi chưa hiểu ý bạn. Bạn có thể hỏi về nhẫn, dây chuyền, vòng tay hoặc bông tai.',
    //         'Hãy hỏi tôi về các sản phẩm trang sức hoặc dịch vụ của Jewelry Shop nhé!',
    //         'Tôi có thể tư vấn về trang sức. Bạn quan tâm đến sản phẩm nào?'
    //     ];

    //     return $defaultResponses[array_rand($defaultResponses)];
    // }
}
