<?php

namespace App\Http\Controllers\Admin\Products;

use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\ProductRatings\Repositories\Interfaces\ProductRatingRepositoryInterface;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Exceptions\ProductInvalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Requests\CreateProductRequest;
use App\Shop\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\productRating;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $productratingRepo;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepo;

    /**
     * @var AttributeValueRepositoryInterface
     */
    private $attributeValueRepository;

    /**
     * @var ProductAttribute
     */
    private $productAttribute;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepo;

    /**
     * ProductController constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     * @param ProductAttribute $productAttribute
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttribute $productAttribute,
        BrandRepositoryInterface $brandRepository,
        ProductRatingRepositoryInterface $productratingRepository
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttribute = $productAttribute;
        $this->brandRepo = $brandRepository;
        $this->productratingRepo = $productratingRepository;

        //$this->middleware(['permission:create-product, guard:vendor'], ['only' => ['create', 'store']]);
        //$this->middleware(['permission:update-product, guard:vendor'], ['only' => ['edit', 'update']]);
        //$this->middleware(['permission:delete-product, guard:vendor'], ['only' => ['destroy']]);
        //$this->middleware(['permission:view-product, guard:vendor'], ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();


        if (isset(auth('admin')->user()->id)) {

            return view('admin.products.list', [
                'products' => $this->productRepo->listProducts(),
                'categories' => $this->categoryRepo->listCategories(),
                'category_products' => DB::table('category_product')->get(),
                'reviews' => $this->productratingRepo->listProductRatings(),
            ]);
        }
    }

    public function productlist()
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();
        $id = auth('vendor')->user()->business_type;
        $categories = DB::table('categories')->where('parent_id', $id)->orderby('name', 'asc')->get();

        if (isset(auth('vendor')->user()->id)) {
            // $product_limit = DB::table('memberships')
            //                     ->join('vendors', 'vendors.plan_id', '=', 'memberships.id')
            //                     ->select('memberships.quantity')
            //                     ->where('vendors.id', auth('vendor')->user()->id)
            //                     ->first();
            // echo "<pre>"; print_r($product_limit);

            $shops = DB::table('shops')->where('merchant_id', auth('vendor')->user()->id)->where('type', 'default')->first();

            return view('admin.products.Vendorlist', [
                'products' => DB::table('products')->where('vendor_id', auth('vendor')->user()->id)->where('shop_id', $shops->id)->orderby('id', 'desc')->paginate(10),
                'products_count' => DB::table('products')->where('vendor_id', auth('vendor')->user()->id)->where('shop_id', $shops->id)->count(),
                'categories' => $categories,
                'category_products' => DB::table('category_product')->get(),
                'reviews' => $this->productratingRepo->listProductRatings(),
                //'product_limit' => $product_limit,
            ]);
        }
    }


    public function shop_productlist(int $id)
    {
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }

        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();
        $iid = auth('vendor')->user()->business_type;
        $shop = DB::table('shops')->where('id', $id)->first();
        $categories = DB::table('categories')->where('parent_id', $shop->title)->orderby('name', 'asc')->get();

        if (isset(auth('vendor')->user()->id)) {

            return view('admin.products.Vendorlist', [
                'products' => DB::table('products')->where('vendor_id', auth('vendor')->user()->id)->where('shop_id', $id)->orderby('id', 'desc')->paginate(10),
                'products_count' => DB::table('products')->where('vendor_id', auth('vendor')->user()->id)->where('shop_id', $id)->count(),
                'categories' => $categories,
                'category_products' => DB::table('category_product')->get(),
                'reviews' => $this->productratingRepo->listProductRatings(),

            ]);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //  $categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();
        $categories = DB::table('categories')->orderby('name', 'asc')->get();
        if (isset(auth('admin')->user()->id)) {
            $vendor = DB::table('vendors')->orderby('id', 'desc')->get();
            $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();

            return view('admin.products.create', [
                'categories' => $categories,
                'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
                'default_weight' => env('SHOP_WEIGHT'),
                'weight_units' => Product::MASS_UNIT,
                'product' => new Product,
                'vendor' => $vendor,
                'tax_rates' => $tax_rates
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productlist_create()
    {

        //  $categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();
        $id = auth('vendor')->user()->business_type;
        $categories = DB::table('categories')->where('parent_id', $id)->orderby('name', 'asc')->get();
        if (isset(auth('vendor')->user()->id)) {
            $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();
            $vendor_canada_post = DB::table('vendor_canadian_posts')->where('vendor_id', auth('vendor')->user()->id)->get();
            $products = DB::table('products')->select('id')->where('vendor_id', auth('vendor')->user()->id)->get();
            $product_limit = DB::table('vendorplan_info')->where('vendor_id', auth('vendor')->user()->id)->orderby('id', 'desc')->first();

            $shop = DB::table('shops')->where('merchant_id', auth('vendor')->user()->id)->where('type', 'default')->first();
            $date = date('Y-m-d');

            return view('admin.products.Vendorcreate', [
                'categories' => $categories,
                'canada_post' => $vendor_canada_post,
                'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
                'default_weight' => env('SHOP_WEIGHT'),
                'weight_units' => Product::MASS_UNIT,
                'product' => new Product,
                'shop' => $shop,
                'tax_rates' => $tax_rates
            ]);
        }
    }

    public function shop_productlist_create(int $id)
    {

        //  $categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();

        $shop = DB::table('shops')->where('id', $id)->first();
        $categories = DB::table('categories')->where('parent_id', $shop->title)->orderby('name', 'asc')->get();
        if (isset(auth('vendor')->user()->id)) {
            $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();
            $vendor_canada_post = DB::table('vendor_canadian_posts')->where('vendor_id', auth('vendor')->user()->id)->get();
            $products = DB::table('products')->select('id')->where('vendor_id', auth('vendor')->user()->id)->get();
            $product_limit = DB::table('vendorplan_info')->where('vendor_id', auth('vendor')->user()->id)->orderby('id', 'desc')->first();
            $date = date('Y-m-d');

            return view('admin.products.Vendorcreate', [
                'categories' => $categories,
                'canada_post' => $vendor_canada_post,
                'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
                'default_weight' => env('SHOP_WEIGHT'),
                'weight_units' => Product::MASS_UNIT,
                'product' => new Product,
                'tax_rates' => $tax_rates
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {

        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover')) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }
        if ($request->taxable == 0) {
            $data['tax_id'] = 0;
        } else {
            $tax_id = $request->tax_id;
            $tax_data = DB::table('tax_rates')->where('id', $tax_id)->first();
            $percentage = $tax_data->rate_percentage;
            $taxPay = $request->sale_price * $percentage / 100;
            $data['tax'] = $taxPay;
            $data['tax_id'] = $request->tax_id;
        }

        $product = $this->productRepo->createProduct($data);

        $productRepo = new ProductRepository($product);

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }

        if ($request->product_type == 'virtual') {
            $name = 'Product';
        } else {
            $name = 'Service';
        }

        return redirect()->route('admin.products.create', $product->id)->with('message', $name . ' added successfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function product_store(CreateProductRequest $request)
    {
        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }

        if ($request->taxable == 0) {
            $data['tax_id'] = 0;
            $data['created_by'] = 1;
        } else {
            $tax_id = $request->tax_id;
            $tax_data = DB::table('tax_rates')->where('id', $tax_id)->first();
            $percentage = $tax_data->rate_percentage;
            $taxPay = $request->sale_price * $percentage / 100;
            $data['tax'] = $taxPay;
            $data['tax_id'] = $request->tax_id;
        }

        $product = $this->productRepo->createProduct($data);

        $productRepo = new ProductRepository($product);

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }

        if ($request->product_type == 'virtual') {
            $name = 'Product';
        } else {
            $name = 'Service';
        }

        return redirect()->back()->with('message', $name . ' added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        $productAttributes = $product->attributes()->get();

        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        //$categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();

        $categories = DB::table('categories')->orderby('name', 'asc')->get();
        if (isset(auth('admin')->user()->id)) {
            $type = 'admin';
        } else if (isset(auth('vendor')->user()->id)) {
            $type = 'vendor';
        }
        $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();

        if ($type == 'admin') {

            return view('admin.products.edit', [
                'product' => $product,
                'images' => $product->images()->get(['src']),
                'categories' => $categories,
                'selectedIds' => $product->categories()->pluck('category_id')->all(),
                'attributes' => $this->attributeRepo->listAttributes(),
                'productAttributes' => $productAttributes,
                'qty' => $qty,
                'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
                'weight' => $product->weight,
                'default_weight' => $product->mass_unit,
                'weight_units' => Product::MASS_UNIT,
                'tax_rates' => $tax_rates
            ]);
        } else if ($type == 'vendor') {
            return view('admin.products.Vendoredit', [
                'product' => $product,
                'images' => $product->images()->get(['src']),
                'categories' => $categories,
                'selectedIds' => $product->categories()->pluck('category_id')->all(),
                'attributes' => $this->attributeRepo->listAttributes(),
                'productAttributes' => $productAttributes,
                'qty' => $qty,
                'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
                'weight' => $product->weight,
                'default_weight' => $product->mass_unit,
                'weight_units' => Product::MASS_UNIT,
                'tax_rates' => $tax_rates
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function product_edit(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        $productAttributes = $product->attributes()->get();

        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        //$categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();

        $id = auth('vendor')->user()->business_type;
        $categories = DB::table('categories')->where('parent_id', $id)->orderby('name', 'asc')->get();

        $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();

        return view('admin.products.Vendoredit', [
            'product' => $product,
            'images' => $product->images()->get(['src']),
            'categories' => $categories,
            'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'attributes' => $this->attributeRepo->listAttributes(),
            'productAttributes' => $productAttributes,
            'qty' => $qty,
            'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'weight' => $product->weight,
            'default_weight' => $product->mass_unit,
            'weight_units' => Product::MASS_UNIT,
            'tax_rates' => $tax_rates
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function shop_product_edit(int $shopId, $productId)
    {
        $product = $this->productRepo->findProductById($productId);
        $productAttributes = $product->attributes()->get();

        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        //$categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();

        $id = auth('vendor')->user()->business_type;
        $shop = DB::table('shops')->where('id', $shopId)->first();
        $categories = DB::table('categories')->where('parent_id', $shop->title)->orderby('name', 'asc')->get();

        $tax_rates = DB::table('tax_rates')->orderby('id', 'desc')->get();

        return view('admin.products.Vendoredit', [
            'product' => $product,
            'images' => $product->images()->get(['src']),
            'categories' => $categories,
            'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'attributes' => $this->attributeRepo->listAttributes(),
            'productAttributes' => $productAttributes,
            'qty' => $qty,
            'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'weight' => $product->weight,
            'default_weight' => $product->mass_unit,
            'weight_units' => Product::MASS_UNIT,
            'tax_rates' => $tax_rates
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\Products\Exceptions\ProductUpdateErrorException
     */
    public function update(UpdateProductRequest $request, int $id)
    {

        $product = $this->productRepo->findProductById($id);
        $productRepo = new ProductRepository($product);

        if ($request->has('attributeValue')) {
            $this->saveProductCombinations($request, $product);
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1])
                ->with('message', 'Attribute combination created successful');
        }

        $data = $request->except(
            'categories',
            '_token',
            '_method',
            'default',
            'image',
            'productAttributeQuantity',
            'productAttributePrice',
            'attributeValue',
            'combination'
        );

        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover')) {
            $data['cover'] = $productRepo->saveCoverImage($request->file('cover'));
        }

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }
        if ($request->taxable == 0) {
            $data['tax_id'] = 0;
        } else {
            $tax_id = $request->tax_id;
            $tax_data = DB::table('tax_rates')->where('id', $tax_id)->first();
            $percentage = $tax_data->rate_percentage;
            $taxPay = $request->sale_price * $percentage / 100;
            $data['tax'] = $taxPay;
            $data['tax_id'] = $request->tax_id;
        }
        if ($request->flat_rate == 0) {
            $data['flat_amount'] = 0;
        }
        $productRepo->updateProduct($data);


        if ($request->product_type == 'virtual') {
            $name = 'Product';
        } else {
            $name = 'Service';
        }
        return redirect()->route('admin.products.edit', $id)
            ->with('message', $name . ' Updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\Products\Exceptions\ProductUpdateErrorException
     */
    public function product_update(UpdateProductRequest $request, int $id)
    {

        $product = $this->productRepo->findProductById($id);
        $productRepo = new ProductRepository($product);

        if ($request->has('attributeValue')) {
            $this->saveProductCombinations($request, $product);
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1])
                ->with('message', 'Attribute combination created successful');
        }

        $data = $request->except(
            'categories',
            '_token',
            '_method',
            'default',
            'image',
            'productAttributeQuantity',
            'productAttributePrice',
            'attributeValue',
            'combination'
        );

        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover')) {
            $data['cover'] = $productRepo->saveCoverImage($request->file('cover'));
        }

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }
        if ($request->taxable == 0) {
            $data['tax_id'] = 0;
        } else {
            $tax_id = $request->tax_id;
            $tax_data = DB::table('tax_rates')->where('id', $tax_id)->first();
            $percentage = $tax_data->rate_percentage;
            $taxPay = $request->sale_price * $percentage / 100;
            $data['tax'] = $taxPay;
            $data['tax_id'] = $request->tax_id;
        }
        if ($request->flat_rate == 0) {
            $data['flat_amount'] = 0;
        }
        $productRepo->updateProduct($data);
        if ($request->product_type == 'virtual') {
            $name = 'Product';
        } else {
            $name = 'Service';
        }

        return redirect()->back()->with('message', $name . ' Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);
        $productAttr = $product->attributes();

        $productAttr->each(function ($pa) {
            DB::table('attribute_value_product_attribute')->where('product_attribute_id', $pa->id)->delete();
        });

        $productAttr->where('product_id', $product->id)->delete();
        $productRepo = new ProductRepository($product);
        $productRepo->removeProduct();

        return redirect()->route('admin.products.index')->with('message', 'Delete successfully');
    }


    public function destroyy()
    {
        $id = $_POST['id'];
        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);
        $productAttr = $product->attributes();

        $productAttr->each(function ($pa) {
            DB::table('attribute_value_product_attribute')->where('product_attribute_id', $pa->id)->delete();
        });

        $productAttr->where('product_id', $product->id)->delete();
        $productRepo = new ProductRepository($product);
        $productRepo->removeProduct();

        return redirect()->back()->with('message', 'Product deleted successfully');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->productRepo->deleteFile($request->only('product', 'image'), 'uploads');
        return redirect()->back()->with('message', 'Image delete successful');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeThumbnail(Request $request)
    {
        $this->productRepo->deleteThumb($request->input('src'));
        return redirect()->back()->with('message', 'Image delete successful');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return boolean
     */
    private function saveProductCombinations(Request $request, Product $product): bool
    {
        $fields = $request->only(
            'productAttributeQuantity',
            'productAttributePrice',
            'sale_price',
            'default'
        );

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1])
                ->withErrors($errors);
        }

        $quantity = $fields['productAttributeQuantity'];
        $price = $fields['productAttributePrice'];

        $sale_price = null;
        if (isset($fields['sale_price'])) {
            $sale_price = $fields['sale_price'];
        }

        $attributeValues = $request->input('attributeValue');
        $productRepo = new ProductRepository($product);

        $hasDefault = $productRepo->listProductAttributes()->where('default', 1)->count();

        $default = 0;
        if ($request->has('default')) {
            $default = $fields['default'];
        }

        if ($default == 1 && $hasDefault > 0) {
            $default = 0;
        }

        $productAttribute = $productRepo->saveProductAttributes(
            new ProductAttribute(compact('quantity', 'price', 'sale_price', 'default'))
        );

        // save the combinations
        return collect($attributeValues)->each(function ($attributeValueId) use ($productRepo, $productAttribute) {
            $attribute = $this->attributeValueRepository->find($attributeValueId);
            return $productRepo->saveCombination($productAttribute, $attribute);
        })->count();
    }

    /**
     * @param array $data
     *
     * @return
     */
    private function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'productAttributeQuantity' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }

    public function productApprove($id)
    {

        $product = $this->productRepo->findProductById($id);

        $productRepo = new ProductRepository($product);
        if ($product) {
            $data['status'] = 1;
            $productRepo->updateProduct($data);
            return redirect()->back()->with('message', 'Active successfully');
        }
    }

    public function productUnapprove($id)
    {
        $product = $this->productRepo->findProductById($id);
        $productRepo = new ProductRepository($product);
        if ($product) {
            $data['status'] = 0;
            $productRepo->updateProduct($data);
            return redirect()->back()->with('error', 'Inctive successfully');
        }
    }

    public function CategoryListingFilter(Request $request)
    {


        $sortByCategory = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';


        if (!empty($sortByCategory)) {
            return $resumes = DB::table('products')->join('category_product', 'category_product.product_id', '=', 'products.id')->select('products.*')
                ->where('category_product.category_id', $sortByCategory)
                ->where('vendor_id', auth('vendor')->user()->id)
                ->get();
        } else if (empty($sortByCategory)) {
            return $resumes = DB::table('products')->where('vendor_id', auth('vendor')->user()->id)
                ->get();
        }
    }
}
