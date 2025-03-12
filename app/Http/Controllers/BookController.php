<?php  
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
class BookController extends Controller
{
    public function index()
    { 
        return Inertia::render('Books/Index');
    }
    public function fetch()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'download_link' => 'nullable|string'
        ]);

        if($request->id)
        {
            $book = Book::findOrFail($request->id);
        }
        else
        {

            $book = new Book();
            $book->id = Str::orderedUuid();
        }
        $book->title = $request->title;
        $book->description = $request->description;
        $book->image = $request->image;
        $book->download_link = $request->download_link;
        $book->save();

        return response()->json(['message' => 'Book saved successfully.'], 200);
    }

    
  

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return response()->json(['message' => 'Book deleted successfully.'], 200);
    }
}
