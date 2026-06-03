<?php

namespace App\Http\Controllers\Admin\Footers;

use App\Http\Controllers\Controller;
use App\Shop\Footers\Repositories\FooterRepository;
use App\Shop\Footers\Repositories\FooterRepositoryInterface;
use App\Shop\Footers\Requests\CreateFooterRequest;
use App\Shop\Footers\Requests\UpdateFooterRequest;
use Illuminate\Http\Request;
use App\Footer; 

class FooterController extends Controller
{
    /**
     * @var FooterRepositoryInterface
     */
    private $FooterRepo;

    /**
     * FooterController constructor.
     *
     * @param FooterRepositoryInterface $FooterRepository
     */
    public function __construct(FooterRepositoryInterface $FooterRepository)
    {
        $this->FooterRepo = $FooterRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       

        $data = $this->FooterRepo->paginateArrayResults($this->FooterRepo->listFooters(['*'], 'title', 'asc')->where('type',$_GET['type'])->all());

        //return view('admin.footers.create', ['Footers' => $data]);
        return view('admin.footers.list', ['footers' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.footers.create');
    }

    /**
     * @param CreateFooterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {        
       
       for ($i = 0; $i < count($request->title); $i++) {
            $answers[] = [
                'title' => $request->title[$i],
                'link' => $request->link[$i],
                'type' => $request->type[$i]
            ];
        }
        
        Footer::insert($answers);

        return redirect()->route('admin.footers.create', 'type='.$request->type[0])->with('message', 'Create Footer successful!');

    }


    

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.footers.edit', ['footer' => $this->FooterRepo->findFooterById($id)]);
    }

    /**
     * @param UpdateFooterRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Footers\Exceptions\UpdateFooterErrorException
     */
    public function update(UpdateFooterRequest $request, $id)
    {
        $Footer = $this->FooterRepo->findFooterById($id);

        $data['title']=$_POST['title'];
        $data['link']=$_POST['link'];
       
        
        $FooterRepo = new FooterRepository($Footer);
        $FooterRepo->updateFooter($data);

        return redirect()->route('admin.footers.edit', $id)->with('message', 'Update successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $Footer = $this->FooterRepo->findFooterById($id);


        $FooterRepo = new FooterRepository($Footer);
        $FooterRepo->deleteFooter();

        return redirect()->route('admin.footers.index','type='.$Footer->type)->with('message', 'Delete successful!');
    }
}
