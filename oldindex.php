<?php
require __DIR__ . '/vendor/autoload.php';
use App\Product;
use App\Admin\Category;
use Intervention\Image\ImageManagerStatic as Image;

$product1 = new Product();
echo $product1->index();
$cat1 = new Category();
echo $cat1->index();


// open and resize an image file
$img = Image::make("assets/images/IMG_20161212_151220.jpg")->resize(800,null,function ($constraint) {
    $constraint->aspectRatio();
})->insert('assets/images/logo.png','center');

// save file as jpg with medium quality
// $img->save('assets/images/IMG_20161212_151220_800x600_60.jpg', 60);
// // save file as jpg with medium quality
// $img->save('assets/images/IMG_20161212_151220_800x600_80.jpg', 80);
// // save file as jpg with medium quality
// $img->save('assets/images/IMG_20161212_151220_800x600_95.jpg', 95);
$img->save(null,60);



