<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatboxController extends Controller
{
    public function index()
    {
        return view('user.chatbox.index');
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
        // Chuyển tin nhắn về chữ thường để dễ xử lý
        $lowerMessage = strtolower($message);

        // Các từ khóa và phản hồi tương ứng
        $responses = [
            // Chào hỏi
            'chào|xin chào|hello|hi' => [
                'Xin chào! Tôi là trợ lý AI của Jewelry Shop. Tôi có thể giúp gì cho bạn hôm nay?',
                'Chào bạn! Tôi có thể tư vấn về trang sức, giá cả, hoặc trả lời các câu hỏi của bạn.',
                'Hello! Chào mừng bạn đến với Jewelry Shop. Bạn cần hỗ trợ gì không?'
            ],

            // Sản phẩm trang sức
            'nhẫn|nhẫn cưới|nhẫn kim cương' => [
                'Chúng tôi có nhiều loại nhẫn đẹp: nhẫn kim cương, nhẫn vàng, nhẫn bạc. Bạn quan tâm đến loại nào?',
                'Nhẫn của shop rất đa dạng về mẫu mã và chất liệu. Bạn có ngân sách dự kiến không?',
                'Nhẫn kim cương của chúng tôi được chế tác từ kim cương thiên nhiên cao cấp. Bạn muốn xem thêm không?'
            ],

            'dây chuyền|vòng cổ' => [
                'Dây chuyền của shop có nhiều kiểu dáng từ cổ điển đến hiện đại. Bạn thích phong cách nào?',
                'Chúng tôi có dây chuyền vàng, bạc và bạch kim với nhiều mẫu mã đẹp.',
                'Dây chuyền là món trang sức rất phù hợp làm quà tặng. Bạn mua để tặng ai không?'
            ],

            'vòng tay|lắc tay' => [
                'Vòng tay vàng của shop rất tinh xảo, được chế tác thủ công bởi các nghệ nhân lành nghề.',
                'Chúng tôi có vòng tay cho cả nam và nữ với nhiều chất liệu khác nhau.',
                'Vòng tay charm rất được ưa chuộng hiện nay. Bạn có muốn xem không?'
            ],

            'bông tai|khuyên tai' => [
                'Bông tai kim cương của shop rất lộng lẫy, phù hợp với các dịp quan trọng.',
                'Chúng tôi có bông tai từ đơn giản đến cầu kỳ, phù hợp mọi phong cách.',
                'Bông tai là điểm nhấn hoàn hảo cho gương mặt. Bạn thích kiểu nào?'
            ],

            // Giá cả
            'giá|giá cả|bao nhiêu tiền|chi phí' => [
                'Giá trang sức phụ thuộc vào chất liệu và thiết kế. Bạn có thể xem chi tiết trên website.',
                'Chúng tôi có sản phẩm từ 500k đến 50 triệu, phù hợp mọi ngân sách.',
                'Shop thường xuyên có khuyến mãi. Bạn có thể theo dõi để mua với giá tốt nhất.'
            ],

            // Chất liệu
            'vàng|kim cương|bạc|bạch kim' => [
                'Tất cả trang sức của shop đều được làm từ chất liệu cao cấp, có chứng nhận chất lượng.',
                'Chúng tôi cam kết 100% về chất lượng vàng, kim cương và các loại đá quý.',
                'Mỗi sản phẩm đều có giấy chứng nhận xuất xứ và chất lượng rõ ràng.'
            ],

            // Dịch vụ
            'bảo hành|đổi trả|giao hàng' => [
                'Shop bảo hành trọn đời cho trang sức, hỗ trợ vệ sinh và sửa chữa miễn phí.',
                'Chính sách đổi trả trong 30 ngày, giao hàng toàn quốc với bảo hiểm.',
                'Dịch vụ của shop rất chu đáo, bạn có thể yên tâm mua sắm.'
            ],

            // Tư vấn
            'tư vấn|chọn|lựa chọn|phù hợp' => [
                'Tôi có thể tư vấn trang sức phù hợp dựa trên sở thích và ngân sách của bạn.',
                'Hãy cho tôi biết bạn muốn mua trang sức cho dịp gì để tư vấn phù hợp nhất.',
                'Bạn có thể mô tả phong cách yêu thích để tôi gợi ý sản phẩm phù hợp.'
            ],

            // Cảm ơn, kết thúc
            'cảm ơn|thank you|thanks' => [
                'Không có gì! Rất vui được hỗ trợ bạn.',
                'Cảm ơn bạn đã quan tâm đến Jewelry Shop!',
                'Chúc bạn tìm được món trang sức ưng ý!'
            ],

            'tạm biệt|bye|goodbye' => [
                'Tạm biệt! Hẹn gặp lại bạn!',
                'Chúc bạn một ngày tốt lành!',
                'Bye bye! Nhớ quay lại shop nhé!'
            ]
        ];

        // Tìm phản hồi phù hợp
        foreach ($responses as $pattern => $responseList) {
            if (preg_match('/(' . $pattern . ')/i', $lowerMessage)) {
                return $responseList[array_rand($responseList)];
            }
        }

        // Phản hồi mặc định
        $defaultResponses = [
            'Tôi không hiểu rõ câu hỏi của bạn. Bạn có thể hỏi về trang sức, giá cả, hoặc dịch vụ của shop.',
            'Xin lỗi, tôi chưa hiểu ý bạn. Bạn có thể hỏi về nhẫn, dây chuyền, vòng tay hoặc bông tai.',
            'Hãy hỏi tôi về các sản phẩm trang sức hoặc dịch vụ của Jewelry Shop nhé!',
            'Tôi có thể tư vấn về trang sức. Bạn quan tâm đến sản phẩm nào?'
        ];

        return $defaultResponses[array_rand($defaultResponses)];
    }
}
