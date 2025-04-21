<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Storage;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index');
    }
    public function fetch()
    {
        $books = Book::all();
        foreach ($books as $book) {
            // Handle receipt image
            if ($book->image) {
                $upload      = Upload::where('id', $book->image)->first();
                $book->image = $upload ? getFileUrl($upload->file_name) : null;
            }
        }
        return $books;

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
        $book->title       = $request->title;
        $book->description = $request->description;
        // Handle receipt image
        if ($request->image) {
            // Delete existing image if any
            if ($book->image) {
                $existing = Upload::find($book->image);
                if ($existing) {
                    Storage::disk('public')->delete($existing->file_name);
                    File::delete(public_path('storage/' . $existing->file_name)); // remove from public
                    $existing->delete();
                }
            }

            // Decode Base64 image
            $data = substr($request->image, strpos($request->image, ',') + 1);
            $data = base64_decode($data);

            // Generate image path
            $image_name = Str::random(40) . '.png';
            $image_path = 'BooksImages/' . $image_name;

            // Store in storage/app/public
            Storage::disk('public')->put($image_path, $data);

            // Copy into public/storage manually (for Hostinger or shared hosting)
            $source      = storage_path('app/public/' . $image_path);
            $destination = public_path('storage/' . $image_path);
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);

            // Save upload record
            $upload                     = new Upload();
            $upload->file_original_name = $image_name;
            $upload->extension          = 'png';
            $upload->type               = 'image/png';
            $upload->file_name          = $image_path;
            $upload->save();

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
