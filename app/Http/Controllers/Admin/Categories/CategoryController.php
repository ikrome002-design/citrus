<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Categories\Requests\CreateCategoryRequest;
use App\Shop\Categories\Requests\UpdateCategoryRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        EmployeeRepositoryInterface $employeeRepository)
    {
        $this->categoryRepo = $categoryRepository;
        $this->employeeRepo = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->categoryRepo->listCategories('created_at', 'desc');
        $categories=$this->categoryRepo->paginateArrayResults($list->all());
        foreach($categories as $parent_categories){
           $parent_id=$parent_categories->parent_id;
           $parent_categories['title'] = DB::table('business_type')->where('id', $parent_id)->get();
        }
        
        return view('admin.categories.list', [
            'categories' =>$categories,
            //'category'=>$category,
            'employees'  => $this->employeeRepo->listEmployees('created_at', 'desc')
        ]);
    }


    public function business_type_index()
    {
        $business_type = DB::table('business_type')->orderBy('id','desc')->get();

       
        return view('admin.businesstype.list', [
            'business_type' =>$business_type
        ]);
    }

 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function type($id)
    { 
        if($id==1){

        $list = DB::table('categories')->where('is_visible_main', 1)->orderby('created_at', 'desc')->get();
       }else{
        $list = DB::table('categories')->where('is_visible_main', 0)->orderby('created_at', 'desc')->get();}
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
        $parent_categories=DB::table('business_type')->orderby('id', 'asc')->get();
        return view('admin.categories.create', [
            'categories' => $this->categoryRepo->listCategories('name', 'asc'),'parent_categories' => $parent_categories
        ]);
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
       
        $this->categoryRepo->createCategory($request->except('_token', '_method'));

        return redirect()->route('admin.categories.index')->with('message', 'Category created');
    }


    public function business_type_store(Request $request)
        {

        $input= $request->all();
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
    public function edit($id)
    {
        $category=$this->categoryRepo->findCategoryById($id);
        $parent_category=DB::table('business_type')->where('id',$category->parent_id)->first();
        $parent_categories=DB::table('business_type')->where('id','!=',$parent_category->id)->orderby('id', 'asc')->get();

            
        return view('admin.categories.edit', [
            'parent_categories' => $parent_categories,
            'category' => $category,
            'parent_category' =>$parent_category
            

        ]);
    }

    public function business_type_edit($id)
    {
        
        $business_type=DB::table('business_type')->where('id',$id)->first();
       
            
        return view('admin.businesstype.edit', [
            'business_type' => $business_type
   
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        DB::table('categories')->where('id', $id)->update(['parent_id' => $request->parent_id, 'name' => $request->name]);
        
    
        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.categories.edit', $id);
    }

    public function business_type_update(Request $request, $id)
    {
        DB::table('business_type')->where('id', $id)->update(['title' => $request->title]);
        
    
        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.business_type.edit', $id);
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

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.categories.index');
    }

    public function business_type_destroy(int $id)
    {
        $business_type = DB::table('business_type')->where('id', $id);
        $business_type->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.business_type.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->categoryRepo->deleteFile($request->only('category'));
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->route('admin.categories.edit', $request->input('category'));
    }
}
