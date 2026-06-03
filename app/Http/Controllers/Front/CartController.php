<?php

namespace App\Http\Controllers\Front;

use App\Shop\Carts\Requests\AddToCartRequest;
use App\Shop\Carts\Requests\UpdateCartRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop\Vendors\Vendor;
use App\Shop\Vendors\Repositories\Interfaces\VendorRepositoryInterface;

class CartController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepo;

    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     * @param CourierRepositoryInterface $courierRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CourierRepositoryInterface $courierRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->productRepo = $productRepository;
        $this->courierRepo = $courierRepository;
        $this->productAttributeRepo = $productAttributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courier = $this->courierRepo->findCourierById(request()->session()->get('courierId', 1));
        $shippingFee = $this->cartRepo->getShippingFee($courier);
        return view('front.carts.cart', [
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'shippingFee' => $shippingFee,
            'total' => $this->cartRepo->getTotal(2, $shippingFee)
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddToCartRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        $product = $this->productRepo->findProductById($request->input('product'));

        if ($product->attributes()->count() > 0) {
            $productAttr = $product->attributes()->where('default', 1)->first();

            if (isset($productAttr->sale_price)) {
                $product->price = $productAttr->price;

                if (!is_null($productAttr->sale_price)) {
                    $product->price = $productAttr->sale_price;
                }
            }
        }

        $options = [];
        if ($request->has('productAttribute')) {

            $attr = $this->productAttributeRepo->findProductAttributeById($request->input('productAttribute'));
            $product->price = $attr->price;

            $options['product_attribute_id'] = $request->input('productAttribute');
            $options['combination'] = $attr->attributesValues->toArray();
        }

        $this->cartRepo->addToCart($product, $request->input('quantity'), $options);

        return redirect()->route('cart.index')
            ->with('message', 'Product Added to cart successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, $id)
    {   
        if($request->input('quantity') < 1){
            $this->cartRepo->removeToCart($id);
        }else{
            $this->cartRepo->updateQuantityInCart($id, $request->input('quantity'));
        }
        $courier = $this->courierRepo->findCourierById(request()->session()->get('courierId', 1));
        $shippingFee = $this->cartRepo->getShippingFee($courier);

      
        return view('front.carts.cartTable', [
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'shippingFee' => $shippingFee,
            'total' => $this->cartRepo->getTotal(2, $shippingFee)
        ])->with('message', 'Update cart successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cartRepo->removeToCart($id);

        request()->session()->flash('message', 'Product removed from cart successfully');
        return redirect()->route('cart.index');
    }
    
}
