<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryies = Category::all()->toArray();
        return response()->json($categoryies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'message' => $validator->errors()], 401);
        }

        $data = $request->all();
        $category = Category::create($data);
           
        return response()->json(['status' => (bool) $category, 'message' => $category ? 'Category Created' : 'Error Creating Category']);
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function tasks($category)
    {
dd('f');
        $tasks = $category->tasks()->orderBy('order')->get();
        
        return response()->json($tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'message' => $validator->errors()], 401);
        }

        $data = $request->all();
        $status = $category->update($data);

           
        return response()->json(['status' => (bool) $status, 'message' => $status ? 'Category Updated!' : 'Error Updating Category']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $status = $category->delete();
        return response()->json(['status' => $status, 'message' =>  $status ? 'Category Deleted' : 'Error Deleting Category']);
    }
}
