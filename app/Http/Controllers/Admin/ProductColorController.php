<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProductColorRequest;
use App\Repositories\Interfaces\ProductColorRepositoryInterface;

class ProductColorController extends Controller
{
    private $productColorRepository;

    public function __construct(ProductColorRepositoryInterface $productColorRepository)
    {
        $this->productColorRepository = $productColorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.productColor.index', [
            'colors' => $this->productColorRepository->allProductColor(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductColorRequest $request)
    {
        $data = [
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'color_code' => $request->color_code,
        ];
        $this->productColorRepository->storeProductColor($data);

        Session::flash('success', ['message' => 'Color added successfully']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductColorRequest $request, $id)
    {
        $data = [
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'color_code' => $request->color_code,
        ];

        $this->productColorRepository->updateProductColor($data, $id);
        Session::flash('success', ['message' => 'Color updated successfully']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productColorRepository->destroyProductColor($id);
    }
}
