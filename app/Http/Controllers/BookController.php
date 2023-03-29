<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookStore;
use function GuzzleHttp\Promise\all;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        // for handling image

        $file = $request->file('image');

        $validatedData =$request->validate([
            'title' => 'required|max:255|min:10|unique:books',
            'description' => 'required',
            'isbn' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/i',
            'price' => 'required|numeric',
            'page' => 'required|numeric',
            'pdate' => 'required|date_format:m/d/Y',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif'
        ]);

        // dd(Auth::user()->id);
        $validatedData['image'] =$file->storeAs('Book Image',$file->getClientOriginalName());
        $validatedData['user_id']=Auth::user()->id;
            Book::create($validatedData);


          return redirect('/home');

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
        return view('edit', compact('book'));

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
            'image' => 'required|image|mimes:png,jpg,jpeg,gif'
        ]);

        // dd(Auth::user()->id);
        $validatedData['image'] = $file->storeAs('Book Image', $file->getClientOriginalName());
        $validatedData['user_id'] = Auth::user()->id;
        $book->fill($validatedData);
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
