<?php

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
                'Tiên Hiệp' => 'tien-hiep',
                'Kiếm Hiệp' => 'kiem-hiep',
                'Ngôn Tình' => 'ngon-tinh',
                'Đô Thị' => 'do-thi',
                'Huyền Huyễn' => 'huyen-huyen',
                'Khoa Huyễn' => 'khoa-huyen',
                'Quan Trường' => 'quan-truong',
                'Võng Du' => 'vong-du',
                'Dị Giới' => 'di-gioi',
                'Dị Năng' => 'di-nang',
                'Quân Sự' => 'quan-su',
                'Lịch Sử' => 'lich-su',
                'Xuyên Không' => 'xuyen-khong',
                'Trọng Sinh' => 'trong-sinh',
                'Trinh Thám' => 'trinh-tham',
                'Thám Hiểm' => 'tham-hiem',
                'Linh Dị' => 'linh-di',
                'Sắc' => 'sac',
                'Ngược' => 'nguoc',
                'Sủng' => 'sung',
                'Cung Đấu' => 'cung-dau',
                'Gia Đấu' => 'gia-dau',
                'Nữ Cường' => 'nu-cuong',
                'Nữ Phụ' => 'nu-phu',
                'Đam Mỹ' => 'dam-my',
                'Bách Hợp' => 'bach-hop',
                'Cổ Đại' => 'co-dai',
                'Mạt Thế' => 'mat-the',
                'Điền Văn' => 'dien-van',
                'Đoản Văn' => 'doan-van',
                'Hài Hước' => 'hai-huoc',
                'Truyện Teen' => 'truyen-teen',
                'Đông Phương' => 'dong-phuong',
                'Tây Phương' => 'tay-phuong',
                'Việt Nam' => 'viet-nam',
                'Light Novel' => 'light-novel',
                'Cổ Tích' => 'co-tich',
                'Thần Thoại' => 'than-thoai',
                'Ngụ Ngôn' => 'ngu-ngon',
                'Kinh Dị' => 'kinh-di'
            );
        foreach($array as $key => $value) {
            PostType::create(['name' => $key, 'slug' => $value]);
        }
    }
}
