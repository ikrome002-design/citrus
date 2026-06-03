<?php

use App\Shop\Products\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {   
        \DB::table('products')->insert(array (
            0 =>
                array ( 
                        'id' => 1,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Redmi 8A Dual (Midnight Grey, 32 GB)  (2 GB RAM)',
                        'slug' => str_slug('Redmi 8A Dual (Midnight Grey, 32 GB)  (2 GB RAM)'),
                        'short_description' => '13+2MP dual rear AI camera with PDAF | 8MP front camera. 15.7988 centimeters (6.22-inch) HD+',
                        'description' => '<ul><li>13+2MP dual rear AI camera with PDAF | 8MP front camera</li> <li>15.7988 centimeters (6.22-inch) HD+ Dot notch display with 1520 x 720 pixels resolution and 19:9 aspect ratio | 2.5D curved glass</li> <li>Memory, Storage &amp; SIM: 2GB | 32GB internal memory expandable up to 512GB with dedicated memory card slot | Dual SIM (nano+nano) dual-standby (4G+4G)</li> <li>Android Pie v9.0 operating system with 1.95GHz Snapdragon 439 octa core processor</li> <li>5000mAH lithium-polymer battery</li> <li>1 year manufacturer warranty for device and 6 months manufacturer warranty for in-box accessories including batteries from the date of purchase</li> <li>Box also includes: Power adapter, USB cable, SIM eject tool, warranty card and user guide. The box does not include earphones</li> </ul>',
                        'cover' => 'products/mi-redmi-8a-dual.jpeg',
                        'quantity' => 100,
                        'price' => 115.00,
                        'sale_price' => 100.00,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>0,
                        'flat_amount'=>0,
                        'length'=>12,
                        'width'=>50,
                        'height'=>30,
                        'created_by'=>1
                ),
            1 =>
                array ( 
                        'id' => 2,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Glamcci Women Two Piece Dress',
                        'slug' => str_slug('Glamcci Women Two Piece Dress'),
                        'short_description' => '<ul class="a-unordered-list a-vertical a-spacing-mini"> <li>Department: women</li> <li>Excellent gift item</li> <li>Comfortable to wear</li> </ul>',
                        'description' => '<ul class="a-unordered-list a-vertical a-spacing-mini"> <li>Department: women</li> <li>Excellent gift item</li> <li>Comfortable to wear</li> </ul>',
                        'cover' => 'products/women-dress.jpeg',
                        'quantity' => 100,
                        'price' => 15.77,
                        'sale_price' => 12.99,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>0,
                        'flat_amount'=>0,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            2 =>
                array ( 
                        'id' => 3,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Solid Men Polo Neck Multicolor T-Shirt',
                        'slug' => str_slug('Solid Men Polo Neck Multicolor T-Shirt'),
                        'short_description' => '<ul> <li>Care Instructions: Machine Wash</li> <li>Fit Type: Regular Fit</li> <li>Fabric : Cotton Blend</li> <li>Pattern : Solid, Logo Embroidery</li> <li>Occasion : Casual</li> <li>Sleeve : Half Sleeve</li> </ul>',
                        'description' => '<ul class="a-unordered-list a-vertical a-spacing-mini"> <li>Care Instructions: Machine Wash</li> <li>Fit Type: Regular Fit</li> <li>Fabric : Cotton Blend</li> <li>Pattern : Solid, Logo Embroidery</li> <li>Occasion : Casual</li> <li>Sleeve : Half Sleeve</li> </ul>',
                        'cover' => 'products/mens-t-shirts-solid-color.jpeg',
                        'quantity' => 100,
                        'price' => 10.77,
                        'sale_price' => 8.00,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>10,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            
            3 =>
                array ( 
                        'id' => 4,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Mattel Scrabble Original - Brand Crossword Board Game',
                        'slug' => str_slug('Mattel Scrabble Original - Brand Crossword Board Game'),
                        'short_description' => 'Test your vocabulary and word skills with this Scrabble Original – Brand Crossword Game from Mattel. Every word counts in this game and you are in for an enriching experience when you play to make random words from alphabets.',
                        'description' => 'Includes letter tiles and board The set includes 100 letter tiles, 1 playing board, 4 racks, cotton tile bag and rules sheet. 2 - 4 players can play the game and it is a perfect party game. Improves vocabulary and strategy skills Word games help develop vocabulary. It stimulates the brain and improves strategic skill, all the while encouraging group play.',
                        'cover' => 'products/scrabble-latest-board-game-multi-color-board-game.jpeg',
                        'quantity' => 100,
                        'price' => 20.00,
                        'sale_price' => 14.99,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>2,
                        'shop_id'=>2,
                        'flat_rate' =>1,
                        'flat_amount'=>10,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            4 =>
                array ( 
                        'id' => 5,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Aquire Large PVC Vinyl Sticker  (Pack of 1)',
                        'slug' => str_slug('Aquire Large PVC Vinyl Sticker  (Pack of 1)'),
                        'short_description' => 'wall stickers for bedroom,wall stickers for bedroom love,wall stickers in home decoration,wall decor stickers for bedroom,sticker for living room',
                        'description' => 'wall stickers for bedroom,wall stickers for bedroom love,wall stickers in home decoration,wall decor stickers for bedroom,sticker for living room',
                        'cover' => 'products/wall-stickers-hanging-birds-cage-with-flowers-large.jpeg',
                        'quantity' => 100,
                        'price' => 5.00,
                        'sale_price' => 4.50,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>2,
                        'shop_id'=>2,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            5 =>
                array ( 
                        'id' => 6,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Sehaz Artworks NM-Adventure_Book Album  (Photo Size Supported: 6 x 4 Inch)',
                        'slug' => str_slug('Sehaz Artworks NM-Adventure_Book Album  (Photo Size Supported: 6 x 4 Inch)'),
                        'short_description' => 'KEEP THE BEST MEMORY! You can record all your wonderful moments that with friends or family in this photo album. And it will be a special DIY gifts for Anniversary, valentine’s day, mother\'s day, father\'s day, birthday, Christmas day, thanksgiving day, etc',
                        'description' => 'KEEP THE BEST MEMORY! You can record all your wonderful moments that with friends or family in this photo album. And it will be a special DIY gifts for Anniversary, valentine’s day, mother\'s day, father\'s day, birthday, Christmas day, thanksgiving day, etc Our premium scrapbook photo album can be carried when you are traveling on a cruise, hiking, camping, fishing, and much more. The book can hold perfectly photos, postcards and can even be used for crafting projects. It also can be used as a wedding memory book. Record all your or with your family / friends special memories on the pages! What’s In The Box? • 1 Scrapbook We offer a lifetime guarantee on this scrapbook photo album, your satisfaction is guaranteed! for some reason if you are not satisfied, please contact us and let us know how to make it better.',
                        'cover' => 'products/nm-adventure-book.jpeg',
                        'quantity' => 100,
                        'price' => 16.00,
                        'sale_price' => 15.00,
                        'status' => 1,
                        'weight' => 5,
                        'product_type' => 'virtual',
                        'mass_unit' => config('shop.weight', 'gms'),
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>30,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            6 =>
                array ( 
                        'id' => 7,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Gloss Hair Salon',
                        'slug' => str_slug('Gloss Hair Salon'),
                        'short_description' => 'Gloss Hair Salon',
                        'description' => 'Gloss Hair Salon',
                        'cover' => 'products/hairsaloon.jpg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 19.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                7 =>
                array ( 
                        'id' => 8,
                        'sku' => rand(1111111, 999999),
                        'name' => 'boAt BassHeads 172 Wired Headset  (Active Black, In the Ear)',
                        'slug' => str_slug('boAt BassHeads 172 Wired Headset  (Active Black, In the Ear)'),
                        'short_description' => 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound.',
                        'description' => 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound. A secure braided cable emphasises the colour and makes it hard to get tangled up. Set with a 120cm cable and 3.5 mm jack, connect into your music and movies anytime and anyplace. Its HD Sound, on demand and is perfect for you to tune out and go within, to place where you keep your good vibes. Turn up the atmosphere with the Bassheads 172.',
                        'cover' => 'products/earphone.jpeg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 21.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                8 =>
                array ( 
                        'id' => 9,
                        'sku' => rand(1111111, 999999),
                        'name' => 'SOFTSPUN Microfiber Vehicle Washing Cloth  (Pack Of 4, 340 GSM)',
                        'slug' => str_slug('SOFTSPUN Microfiber Vehicle Washing Cloth  (Pack Of 4, 340 GSM)'),
                        'short_description' => 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No',
                        'description' => 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No Odor-Bacteria Free-Wrinkle Free-Light Weight-Lasts Hundreds Of Washes-Very Economical SOFTSPUN Microfiber is the fastest growing Microfiber Products company in India having a extensive range of products, sizes and colors to suit all needs',
                        'cover' => 'products/soft.jpeg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 20.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                9 =>
                array ( 
                        'id' => 10,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Happilo 100% Natural Premium Californian Almonds',
                        'slug' => str_slug('Happilo 100% Natural Premium Californian Almonds'),
                        'short_description' => 'Happilo 100% Natural Premium Californian Almonds Descriptions',
                        'description' => 'Happilo 100% Natural Premium Californian Almonds Descriptions',
                        'cover' => 'products/foodLEVELS-10023-1000x800.jpg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 22.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>2,
                        'shop_id'=>2,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                10 =>
                array ( 
                        'id' => 11,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Kwality Choco Flakes',
                        'slug' => str_slug('Kwality Choco Flakes'),
                        'short_description' => 'Kwality Choco Flakes Descriptions',
                        'description' => 'Kwality Choco Flakes Descriptions',
                        'cover' => 'products/food2.jpg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 24.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>2,
                        'shop_id'=>2,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                11 =>
                array ( 
                        'id' => 12,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Craftastique Forever Love Designer',
                        'slug' => str_slug('Craftastique Forever Love Designer'),
                        'short_description' => 'Craftastique Forever Love Designer',
                        'description' => 'Kwality Choco Flakes Descriptions',
                        'cover' => 'products/DIY-Art-and-Craft.jpg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 17.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>2,
                        'shop_id'=>2,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                12 =>
                array ( 
                        'id' => 13,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Happy walls Nature Wallpaper ',
                        'slug' => str_slug('Happy walls Nature Wallpaper '),
                        'short_description' => 'Happy walls Nature Wallpaper description',
                        'description' => 'Happy walls Nature Wallpaper description',
                        'cover' => 'products/download.jpeg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 11.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
                13 =>
                array ( 
                        'id' => 14,
                        'sku' => rand(1111111, 999999),
                        'name' => 'Mi XXQ02HM Runtime: 60 min Trimmer for Men ',
                        'slug' => str_slug('Mi XXQ02HM Runtime: 60 min Trimmer for Men'),
                        'short_description' => 'HMi XXQ02HM Runtime: 60 min Trimmer for Men description',
                        'description' => 'Mi XXQ02HM Runtime: 60 min Trimmer for Men description',
                        'cover' => 'products/download (1).jpeg',
                        'quantity' => 100,
                        'price' => 25.00,
                        'sale_price' => 23.00,
                        'status' => 1,
                        'weight' => NULL,
                        'product_type' => 'virtual',
                        'mass_unit' => '',
                        'vendor_id'=>1,
                        'shop_id'=>1,
                        'flat_rate' =>1,
                        'flat_amount'=>20,
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'created_by'=>1
                ),
            )
        );

        \DB::table('product_images')->insert( array(

            0 =>
                array ( 
                        'product_id' => '1',
                        'src' => 'products/mi-redmi-8a-dual-2.jpeg'
                ),
            1 =>
                array ( 
                        'product_id' => '1',
                        'src' => 'products/mi-redmi-8a-dual-3.jpeg'
                ),
            2 =>
                array ( 
                        'product_id' => '1',
                        'src' => 'products/mi-redmi-8a-dual-4.jpeg'
                ),
            3 =>
                array ( 
                        'product_id' => '1',
                        'src' => 'products/mi-redmi-8a-dual-5.jpeg'
                ),
            )
        );

        \DB::table('category_product')->insert( array(

            0 =>
                array ( 
                        'product_id' => '1',
                        'category_id' => '1'
                ),
            1 =>
                array ( 
                        'product_id' => '2',
                        'category_id' => '2'
                ),
            2 =>
                array ( 
                        'product_id' => '3',
                        'category_id' => '1'
                ),
            3 =>
                array ( 
                        'product_id' => '4',
                        'category_id' => '5'
                ),
            4 =>
                array ( 
                        'product_id' => '5',
                        'category_id' => '5'
                ),
            5 =>
                array ( 
                        'product_id' => '6',
                        'category_id' => '2'
                ),
            6 =>
                array ( 
                        'product_id' => '7',
                        'category_id' => '1'
                ),
            7 =>
                array ( 
                        'product_id' => '8',
                        'category_id' => '1'
                ),
            8 =>
                array ( 
                        'product_id' => '9',
                        'category_id' => '2'
                ),
            9 =>
                array ( 
                        'product_id' => '10',
                        'category_id' => '3'
                ),
            10 =>
                array ( 
                        'product_id' => '11',
                        'category_id' => '4'
                ),
            11 =>
                array ( 
                        'product_id' => '12',
                        'category_id' => '5'
                ),
            12 =>
                array ( 
                        'product_id' => '13',
                        'category_id' => '2'
                ),
            13 =>
                array ( 
                        'product_id' => '14',
                        'category_id' => '1'
                ),
            
            )
        );
    }
}