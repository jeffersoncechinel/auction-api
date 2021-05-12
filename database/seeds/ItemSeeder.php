<?php

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        Item::create([
            'name' => 'Table Lamp',
            'description' => 'Iluminate your room.',
            'initial_price' => 100,
            'final_price' => 100,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/1.jpg',
        ]);

        Item::create([
            'name' => 'Diamon Ring',
            'description' => 'Classi diamond ring from the queen.',
            'initial_price' => 75000,
            'final_price' => 75000,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/2.jpg',
        ]);

        Item::create([
            'name' => 'Hat',
            'description' => 'Woman hat',
            'initial_price' => 15,
            'final_price' => 15,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/3.jpg',
        ]);

        Item::create([
            'name' => 'Music box',
            'description' => 'An old music box.',
            'initial_price' => 20,
            'final_price' => 20,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/4.jpg',
        ]);

        Item::create([
            'name' => 'Telephone',
            'description' => 'This telephone is from 1970. Pretty new!',
            'initial_price' => 120,
            'final_price' => 120,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/5.jpg',
        ]);

        Item::create([
            'name' => 'Classic Clock',
            'description' => 'This one is legendary!',
            'initial_price' => 400,
            'final_price' => 400,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/6.jpg',
        ]);

        Item::create([
            'name' => 'Royal Mirror',
            'description' => 'You look much better when looking at this mirror.',
            'initial_price' => 200,
            'final_price' => 200,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/7.jpg',
        ]);

        Item::create([
            'name' => 'White Sofa',
            'description' => 'Classic white sofa.',
            'initial_price' => 500,
            'final_price' => 500,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/8.jpg',
        ]);

        Item::create([
            'name' => 'Sewing Machine.',
            'description' => 'Antique sewing machine. Perfect state.',
            'initial_price' => 350,
            'final_price' => 350,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/9.jpg',
        ]);

        Item::create([
            'name' => 'Kings Trone',
            'description' => 'This trone was used by King Harold V',
            'initial_price' => 3500,
            'final_price' => 3500,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/10.jpg',
        ]);

        Item::create([
            'name' => 'Type Machine',
            'description' => 'Old type machine.',
            'initial_price' => 1500,
            'final_price' => 1500,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/11.jpg',
        ]);

        Item::create([
            'name' => 'Classic Tractor Fever',
            'description' => 'This is the classic one.',
            'initial_price' => 80000,
            'final_price' => 80000,
            'finished_at' => $this->finishAt(),
            'image_url' => 'http://127.0.0.1:7123/images/12.jpg',
        ]);
    }

    public static function period()
    {
        return rand(5, 20);
    }

    protected function finishAt()
    {
        $dt = new DateTime(date('Y-m-d H:i:s'));
        $dt->modify("+{$this->period()} minutes");
        return $dt->format('Y-m-d H:i:s');
    }
}
