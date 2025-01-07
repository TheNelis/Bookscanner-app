<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booklist;

class BooklistController extends Controller
{

    public function index()
    {
        $books = Booklist::latest()->paginate(10); // Haalt alle boeken op
        return view('booklist', ['books' => $books]);
    }

    public function addBook(Request $request)
    {
        // Check of het boek al bestaat
        $existingBook = Booklist::where('title', $request->input('title'))
                                ->where('authors', $request->input('authors'))
                                ->first();

        if ($existingBook) {
            // Boek bestaat al, stuur terug met een error message
            return redirect()->back()
                ->with('error', 'Dit boek staat al in je lijst!')
                ->withInput();
        }

        Booklist::create([
            'title' => $request->input('title'),
            'authors' => $request->input('authors', ''), // Gebruik lege string als standaardwaarde
            'image' => $request->input('image', '') // Gebruik lege string als standaardwaarde
        ]);

        return redirect()->back()->with('success', 'Boek toegevoegd!');
    }

    public function destroy($id)
    {
        $book = Booklist::findOrFail($id);
        $book->delete();

        return redirect()->route('booklist')->with('success', 'Boek verwijderd uit je lijst!');
    }
}
