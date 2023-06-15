<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookStore;
use function GuzzleHttp\Promise\all;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->authorizeResource(Book::class, 'index');

        $this->middleware('auth')->except('show');
    }

    public function index(Book $book)
    {

        $books = Book::all();
        return view('home',compact('books'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arra = $request->all();
        $validatedData = Validator::make($request->all(),
            [
                'title' => 'required|max:255|min:10|unique:books',
                'description' => 'required',
                'isbn' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/i',
                'price' => 'required|numeric',
                'page' => 'required|numeric',
                'pdate' => 'required|date_format:m/d/Y'
            ]
            );
        $arra['user_id']=Auth::user()->id;
        $arra['image'] = "Muhammad";
        if($validatedData->fails())
        {
            return response()->json($validatedData->errors(), 422);
        }
            Book::create($arra);
         return response()->json(['Message']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */

    public function show(Book $book)
    {
        $books = Book::findorfail($book->id);
        return view('record',compact('books'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findorfail($id);
        $file = $book->image;
        $filename = explode('/',$file);
        $image = $filename[1];
        return view('edit', compact('book','image'));

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

        $book = Book::findorfail($id);

        $file = $request->file('image');

        $validatedData = $request->validate([
            'title' => 'required|max:255|min:10',
            'description' => 'required',
            'isbn' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/i',
            'price' => 'required|numeric',
            'page' => 'required|numeric',
            'pdate' => 'required|date_format:m/d/Y',
            'image' => 'image|mimes:png,jpg,jpeg,gif'
        ]);
        $validatedData['image'] = $file->storeAs('images', $file->getClientOriginalName());
        $validatedData['user_id'] = Auth::user()->id;

        $book->fill($validatedData);

        $request->image->move(public_path('images'), $validatedData['image']);

        $book->save();

        return redirect('/books');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {

        if(!Gate::allows('delete-post',$book)){
            abort(403,"You Can not delete Record");
        }
        $book->delete();
        return redirect()->route("books.index");
    }

    public function form()
    {
        return view('form');
    }



}
