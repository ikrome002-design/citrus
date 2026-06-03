<?php

namespace App\Http\Controllers\Admin\Blog;
use App\Blogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Shop\Brands\Repositories\BrandRepository;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Brands\Requests\CreateBrandRequest;
use App\Shop\Brands\Requests\UpdateBrandRequest;

class BlogController extends Controller
{
  
   
    public function index()
    { 
       $blogs = Blogs::orderBy('id','desc')->paginate(10);
        return view('admin.blogs.list', [
            'blogs' =>$blogs
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * @param CreateBrandRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $rules = array(
          'title' => 'required',
          'description' => 'required',
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
          
       );

       $this->validate($request, $rules);

        if ($request->has('image') && $request->file('image') != '')
        {
            $file = $request->file('image');
           
            $file->move(public_path('storage/blog/'),$file->getClientOriginalName());
        }

        Blogs::create(['title'=>$request->title,'description'=>$request->description,'image'=>$file->getClientOriginalName()]);

        return back()->with('message', 'Create blog successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    { 
       $blog = Blogs::where('id',$id)->first();
        return view('admin.blogs.edit', [
            'blog' =>$blog
        ]);
    }

    /**
     * @param UpdateBrandRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Brands\Exceptions\UpdateBrandErrorException
     */
    public function update(Request $request, $id)
    {
        $blogs = Blogs::where('id',$id)->get();
       
        if ($request->has('image') && $request->file('image') != ''){
            $file = $request->file('image');
            request()->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ]);
           
           $file->move(public_path('storage/blog/'),$file->getClientOriginalName());

            Blogs::where('id',$id)->update(['title'=>$request->title,'description'=>$request->description,'image'=>$file->getClientOriginalName()]);
            
        }else{
             Blogs::where('id',$id)->update(['title'=>$request->title,'description'=>$request->description]);
        }
       

        return back()->with('message', 'Update successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $blogs =Blogs::where('id',$id);
        $blogs->delete();

        return back()->with('message', 'Delete successfully.');
    }
}
