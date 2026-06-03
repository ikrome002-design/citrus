<?php



use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use App\Models\Order;
use App\Models\ProductChoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


//resize images
function imageResize($image, $storageDir, $width = 1920, $height = 1080)
{
    $ext = $image->getClientOriginalExtension();
    $filename = substr($image->hashName(), 0, strrpos($image->hashName(), '.')) . $ext;
    Image::make($image)->encode($ext, 90)->resize($width, $height, function ($const) {
        $const->aspectRatio();
    })->save($storageDir . '/' . $filename);
    return $filename;
}


function getCartItemsDetails()
{
    // Get the current cart from session
    $cart = session()->get('cart', []);

    $detailed_cart = [];
    $items_count = 0;
    $substotal = 0;

    foreach ($cart as $productChoiceId => $quantity) {
        // Get the product choice
        $choice = ProductChoice::where('id', $productChoiceId)
            ->where('show_choice', 1)
            ->whereHas('product', function ($query) {
                $query->where('show_product', 1);
            })->first();

        if ($choice) {
            $items_count += $quantity;
            $amount = $quantity * $choice->selling_price;
            $substotal += $amount;

            $choicesData = [
                'product_id' => $choice->product->id,
                'product_name' => $choice->product->product_name,
                'product_slug' => $choice->product->product_slug,
                'product_url' => route('single.product', $choice->product->product_slug),
                'product_image' => $choice->product->product_image,
                'product_choice_id' => $choice->id,
                'original_price' => $choice->original_price,
                'selling_price' => $choice->selling_price,
                'product_quantity' => $choice->product_quantity,
                'product_measure' => $choice->product_measure,
                'other_details' => $choice->other_details ?? '',
                'discount_percent' => $choice->discount_percent ?? 0,
                'amount' => 'KSh ' . number_format($amount, 2, '.', ','),
                'quantity' => $quantity,
                'formatted_discount_percent' => $choice->formatted_discount_percent ?? 0,
                'formatted_original_price' => $choice->formatted_original_price,
                'formatted_selling_price' => $choice->formatted_selling_price,
            ];
            $detailed_cart[] = ['choice_data' => $choicesData,];
        }
        if ($quantity == 0) {
            unset($cart[$productChoiceId]);
        }
        if (!$choice) {
            unset($cart[$productChoiceId]);
            if (empty($cart)) {
                unset($cart);
            }
        }
    }
    $cart = $cart ?? [];
    session(['cart' => $cart]);
    $total_price = $substotal;
    $cart_detail = [
        'product_data' => $detailed_cart,
        'items_count' => $items_count,
        'subtotal' =>  'KSh ' . number_format($substotal, 2, '.', ','),
        'total_price' => 'KSh ' . number_format($total_price, 2, '.', ','),

    ];
    return  $cart_detail;
}

function formatDate($date, $format = 'F j, Y')
{
    try {
        $carbonDate = Carbon::parse($date);
        // Format the date as "F j, Y" (e.g., "January 1, 2021")
        return $carbonDate->format('F j, Y');
    } catch (Exception $e) {
        return;
    }
}
function formatMoney($value)
{
    if ($value) {
        return 'KSh ' . number_format($value, 2, '.', ',');
    }
    return 'KSh 0.00';
}



function  dynamicChoices($type)
{


    if ($type == 'payment_type') {
        $p = [
            'cash' => [],
            'mpesa' => []
        ];

        return $p;
    }
    if ($type == 'product_status') {
        $p =  [
            'in stock' => ['bg-primary text-white'],
            'out of stock' => ['bg-dark-subtle text-muted'],
        ];
        return $p;
    }

    if ($type == 'product_measure') {
        $p = ['kg' => [], 'g' => []];
        return $p;
    }
    if ($type == 'order_status') {
        $p = [
            'pending' => ['bg-secondary-subtle text-dark'],
            'partially paid' => ['bg-warning-subtle text-dark'],
            'paid' => ['bg-warning text-dark'],
            'partially confirmed' => ['bg-primary-subtle text-dark'],
            'confirmed' => ['bg-primary-subtle text-dark'],
            'partially shipped' => ['bg-info-subtle text-dark'],
            'shipped' => ['bg-info text-white'],
            'partially delivered ' => ['bg-success-subtle text-dark'],
            'delivered' => ['bg-success text-white'],
            'partially cancelled' => ['bg-danger-subtle text-danger'],
            'cancelled' => ['bg-danger text-white'],
            'partially returned' => ['bg-dark-subtle text-dark'],
            'returned' => ['bg-dark text-white'],
        ];
        return $p;
    }

    if ($type == 'payment_status') {
        $p = [
            'pending' => ['bg-info-subtle text-dark'],
            'completed' => ['bg-primary text-white'],
            'partially refunded' => ['bg-secondary-subtle text-dark'],
            'refunded' => ['bg-danger text-white'],
            'failed' => ['bg-warning text-dark']
        ];
        return $p;
    }
    return;
}
