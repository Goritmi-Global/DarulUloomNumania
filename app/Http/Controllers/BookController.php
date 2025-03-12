<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Storage;
use App\Models\Upload;
class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index');
    }
    public function fetch()
    {
        $books =  Book::all();
        foreach($books as $book)
        {
             // Handle receipt image
             if ($book->image) {
                $upload                     = Upload::where('id', $book->image)->first();
                $book->image = $upload ? getFileUrl($upload->file_name) : null;
            }
        }
        return  $books;
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'image'         => 'nullable|string',
            'download_link' => 'nullable|string',
        ]);

        if ($request->id) {
            $book = Book::findOrFail($request->id);
        } else {

            $book     = new Book();
            $book->id = Str::orderedUuid();
        }
        $book->title         = $request->title;
        $book->description   = $request->description;
         // Handle receipt image
         if ($request->image) {
            if ($book->image) {
                $existingInUploads = Upload::where('id', $book->image)->first();
                if ($existingInUploads) {
                    Storage::delete($existingInUploads->file_name);
                    $existingInUploads->delete();
                }
            }

            // Decode Base64 image
            $data = substr($request->image, strpos($request->image, ',') + 1);
            $data = base64_decode($data);

            // Generate unique file name and path
            $image_name = Str::random(40) . '.png';
            $image_path = 'BooksImages/' . $image_name;

            // Store the image
            Storage::disk('public')->put($image_path, $data);

            // Save file details
            $upload                     = new Upload();
            $upload->file_original_name = $image_name;
            $upload->extension          = 'png';
            $upload->type               = 'image/png';
            $upload->file_name          = $image_path;
            $upload->save();

            // Assign uploaded image to transaction
            $book->image = $upload->id;
        }

        
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
