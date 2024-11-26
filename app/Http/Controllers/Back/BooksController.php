<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index(Request $request)
    {

        $books = $this->getBooks($request);

        return view('back-office.books.index', compact('books'));
    }

    /**Recherche dans la table Book */
    public function getBooks(Request $request)
    {

        if ($request->isMethod('post')) {
            $title = $request->input('title');
            $author = $request->input('author');
            $books = Book::where('title', 'like', '%' . $title . '%')
                ->where('author', 'like', '%' . $author . '%');
            return $books->get();
        } else {
            return Book::all();
        }
    }

    /**Enregistre un emprunt */
    public function empruntStore(Request $request)
    {
        $copie = $request->input('copie');
        $book_id = $request->input('book_id');
        $user = Auth::user();

        Loan::create([
            'book_id' => $book_id,
            'user_id' => $user->id,
            'loan_date' => now(),
        ]);

        $book = Book::find($book_id);
        $disponible = $book->available_copies - $copie;
        $book->update(['available_copies' => $disponible]);

        return redirect()->route('books.index')->with('message', 'Livre emprunté !');
    }

    /**Enregistre un retour */
    public function retourStore(Request $request)
    {
        $copie = $request->input('copie');
        $book_id = $request->input('book_id');
        $user = Auth::user();

        $loan = Loan::where('user_id', $user->id)->where('book_id', $book_id)->first();

        dd($loan);

        $book = Book::find($book_id);
        $disponible = $book->available_copies + $copie;
        $book->update(['available_copies' => $disponible]);

        return redirect()->route('books.index')->with('message', 'Livre rendu !');
    }
}
