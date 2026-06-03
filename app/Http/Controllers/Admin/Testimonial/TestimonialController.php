<?php

namespace App\Http\Controllers\Admin\Testimonial;
use App\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Shop\Brands\Repositories\BrandRepository;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Brands\Requests\CreateBrandRequest;
use App\Shop\Brands\Requests\UpdateBrandRequest;

class TestimonialController extends Controller
{
  
   
    public function index()
    { 
       $testimonials = Testimonials::orderBy('id','desc')->paginate(10);
        return view('admin.testimonials.list', [
            'testimonials' =>$testimonials
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.testimonials.create');
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
           
            $file->move(public_path('storage/testimonial/'),$file->getClientOriginalName());
        }

        Testimonials::create(['title'=>$request->title,'description'=>$request->description,'image'=>$file->getClientOriginalName()]);

        return back()->with('message', 'Create testimonial successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    { 
       $testimonial = Testimonials::where('id',$id)->first();
        return view('admin.testimonials.edit', [
            'testimonial' =>$testimonial
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
        $testimonials = Testimonials::where('id',$id)->get();
       
        if ($request->has('image') && $request->file('image') != ''){
            $file = $request->file('image');
            request()->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ]);
           
           $file->move(public_path('storage/testimonial/'),$file->getClientOriginalName());

            Testimonials::where('id',$id)->update(['title'=>$request->title,'description'=>$request->description,'image'=>$file->getClientOriginalName()]);
            
        }else{
             Testimonials::where('id',$id)->update(['title'=>$request->title,'description'=>$request->description]);
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
        $testimonials =Testimonials::where('id',$id);
        $testimonials->delete();

        return back()->with('message', 'Delete successfully.');
    }
}
