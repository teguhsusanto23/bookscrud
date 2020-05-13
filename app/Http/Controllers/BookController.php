<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use DB;
use Redirect,Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(request()->ajax()) {
            return datatables()->of(Book::select(DB::raw('books.*,(select category from categories where id=books.category_id) category')))
            ->addColumn('action', 'action')
            ->addColumn('checkboxdel', 'checkbok')
            ->rawColumns(['action','checkboxdel'])
            ->addIndexColumn()
            ->make(true);
        }
        $categories = Category::get();
        return view('list',compact('categories'));
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
    public function store(Request $request)
    {
        //
        $bookId = $request->book_id;
        $book   =   Book::updateOrCreate(['id' => $bookId],
                ['title' => $request->title, 'category_id' => $request->category_id, 'author' => $request->author,'publish'=>$request->publish,'isbn'=>$request->isbn]);        
        return Response::json($book);
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
        $where = array('id' => $id);
        $book  = Book::where($where)->first();
        return Response::json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $book = Product::where('id',$id)->delete();
        return Response::json($book);
    }
}
