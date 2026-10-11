<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAboutBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('about_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('');
            $table->text('intro')->nullable();
            $table->text('items')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('decor')->default(1);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        $now = now();
        $blocks = [
            [
                'title' => 'Tầm Nhìn',
                'intro' => 'Trở thành thương hiệu khinh khí cầu được tin chọn tại Việt Nam trong lĩnh vực sự kiện và du lịch trải nghiệm, góp phần tạo nên những chương trình có dấu ấn và những điểm đến giàu sức hút.',
                'items' => [
                    ['title' => 'Thương hiệu được tin chọn', 'description' => 'Xây dựng uy tín bằng chất lượng dịch vụ và cách tổ chức chuyên nghiệp.'],
                    ['title' => 'Sự kiện có dấu ấn riêng', 'description' => 'Phát triển giải pháp sáng tạo, phù hợp chủ đề và nhận diện của từng chương trình.'],
                    ['title' => 'Điểm đến giàu trải nghiệm', 'description' => 'Kết nối khinh khí cầu với văn hóa địa phương và sản phẩm du lịch.'],
                ],
                'decor' => 1,
            ],
            [
                'title' => 'Sứ Mệnh',
                'intro' => 'Mang đến giải pháp khinh khí cầu phù hợp từng chương trình, giúp khách hàng tạo không gian thu hút và trải nghiệm đáng nhớ. Đồng hành từ ý tưởng đến triển khai, lấy an toàn và sự chuyên nghiệp làm nền tảng.',
                'items' => [
                    ['title' => 'Tạo giá trị cho khách hàng', 'description' => 'Kết hợp trang trí, nhận diện thương hiệu và trải nghiệm theo mục tiêu chương trình.'],
                    ['title' => 'Triển khai có trách nhiệm', 'description' => 'Xây dựng phương án rõ ràng, phân công chuyên môn và kiểm soát điều kiện khai thác.'],
                    ['title' => 'Lan tỏa bản sắc địa phương', 'description' => 'Tôn trọng văn hóa và cảnh quan, góp phần quảng bá hình ảnh điểm đến.'],
                ],
                'decor' => 0,
            ],
            [
                'title' => 'Giá trị cốt lõi',
                'intro' => '',
                'items' => [
                    ['title' => 'An toàn và kỷ luật vận hành', 'description' => 'Đánh giá điều kiện trước khi triển khai, phân công đúng chuyên môn và duy trì quyền dừng hoạt động khi điều kiện không bảo đảm.'],
                    ['title' => 'Chuyên nghiệp và minh bạch', 'description' => 'Thống nhất phạm vi, ngân sách và đầu mối phối hợp. Công bố năng lực theo hồ sơ thực tế và làm rõ trách nhiệm của doanh nghiệp, đội ngũ, đối tác.'],
                    ['title' => 'Sáng tạo và tôn trọng bản sắc', 'description' => 'Phát triển màu sắc, hình dáng và bố trí phù hợp chủ đề. Kết hợp nhận diện thương hiệu với đặc trưng địa phương và cách sử dụng không gian.'],
                ],
                'decor' => 1,
            ],
        ];

        foreach ($blocks as $index => $block) {
            DB::table('about_blocks')->insert([
                'title' => $block['title'],
                'intro' => $block['intro'],
                'items' => json_encode($block['items'], JSON_UNESCAPED_UNICODE),
                'image' => null,
                'decor' => $block['decor'],
                'sort' => $index + 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('about_blocks');
    }
}
