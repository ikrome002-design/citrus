<?php

namespace App\Http\Controllers\Admin\Categories;

use App\BusinessType;
use App\DataTables\Admin\CategoryDataTable;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Admin\Categories\Requests\CreateCategoryRequest;
use App\Http\Controllers\Admin\Categories\Requests\UpdateCategoryRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Categories\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->categoryRepo = $categoryRepository;
        $this->employeeRepo = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(CategoryDataTable $dataTable)
    {

        return $dataTable->render('admin.categories.list');
    }


    public function business_type_index()
    {
        $business_type = DB::table('business_type')->orderBy('id', 'desc')->get();
        return view('admin.businesstype.list', compact('business_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function type($id)
    {
        if ($id == 1) {

            $list = DB::table('categories')->where('is_visible_main', 1)->orderby('created_at', 'desc')->get();
        } else {
            $list = DB::table('categories')->where('is_visible_main', 0)->orderby('created_at', 'desc')->get();
        }
        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all()),
            'employees'  => $this->employeeRepo->listEmployees('created_at', 'desc')
        ]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->orderby('id', 'asc')->get();
        $businessTypes = BusinessType::orderby('id', 'asc')->get();

        return view('admin.categories.create', compact('parentCategories', 'businessTypes'));
    }



    public function business_type_create()
    {

        return view('admin.businesstype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {

        $requestData = $request->except('_token', '_method');
        $requestData['featured_image'] = imageResize($request->featured_image, storage_path('app/public/categories'));
        if (isset(auth('admin')->user()->id)) :
            $requestData["created_by"] = auth('admin')->user()->id;
            $requestData["updated_by"] = auth('admin')->user()->id;
        endif;
        $requestData['description'] = preg_replace("/(\r|\n)/", " ", $request->description);
        $this->categoryRepo->createCategory($requestData);

        return redirect()->route('admin.categories.index')->with('message', 'Category created');
    }


    public function business_type_store(Request $request)
    {

        $input = $request->all();
        $user =  DB::table('business_type')->insert([
            'title' => $input['title'],

        ]);

        return redirect()->route('admin.business_type.index')->with('message', 'Business type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->findCategoryById($id);

        $cat = new CategoryRepository($category);

        return view('admin.categories.show', [
            'category' => $category,
            'categories' => $category->children,
            'products' => $cat->findProducts()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        $parentCategories = Category::whereNull('parent_id')->orderby('id', 'asc')->get();
        $businessTypes = BusinessType::orderby('id', 'asc')->get();


        return view('admin.categories.edit', compact('category', 'parentCategories', 'businessTypes'));
    }

    public function business_type_edit(CategoryDataTable $dataTable,  $id)
    {

        $business_type = BusinessType::find($id);


        return $dataTable->render('admin.businesstype.edit', compact('business_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $requestData = $request->except('_token', '_method');
        if ($request->featured_image) {
            Storage::disk('public')->delete('categories/' . $category->featured_image);
            $requestData['featured_image'] = imageResize($request->featured_image, storage_path('app/public/categories'));
        }
        if (isset(auth('admin')->user()->id)) :
            $requestData["updated_by"] = auth('admin')->user()->id;
        endif;
        $requestData['description'] = preg_replace("/(\r|\n)/", " ", $request->description);

        $category->update($requestData);


        return redirect()->route('admin.categories.edit', $category)->with('message', 'Update successful');
    }

    public function business_type_update(Request $request, $id)
    {
        DB::table('business_type')->where('id', $id)->update(['title' => $request->title]);

        return redirect()->route('admin.business_type.edit', $id)->with('message', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = $this->categoryRepo->findCategoryById($id);
        $category->products()->sync([]);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('message', 'Delete successful');
    }

    public function business_type_destroy(int $id)
    {
        $business_type = DB::table('business_type')->where('id', $id);
        $business_type->delete();

        return redirect()->route('admin.business_type.index')->with('message', 'Delete successful');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->categoryRepo->deleteFile($request->only('category'));
        return redirect()->route('admin.categories.edit', $request->input('category'))->with('message', 'Image delete successful');
    }
}
