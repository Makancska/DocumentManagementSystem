<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Permission;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $permission = Permission::where('category_id', $request->input("category_id"))
                                    ->where('can_upload', true)
                                    ->exists();
        if (!$permission) {
            return response()->json(['error' => 'Nincs feltöltési jogosultságod új fájl feltöltéséhez.'], 403);
        }

        $this->validate($request, [
            'name' => 'string',
            'category_id' => 'nullable|integer',
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $filePath = $file->store('documents', 'public');

        $existingFile = Document::where('original_file_name', $originalFileName)->latest('version')->first();
        $version = $existingFile ? $existingFile->version + 1 : 1;

        $document = new Document();
        $document->original_file_name = $originalFileName;
        $document->version = $version;
        $document->user_id = 1;
        $document->name = $request->input("name");
        $document->category_id = $request->input("category_id");
        $document->file_path = $filePath;
        $document->save();

        return json_encode([
            "document" => $document
        ]);
    }

    public function download($categoryId, $fileId)
    {
        $permission = Permission::where('category_id', $categoryId)
                                    ->where('can_download', true)
                                    ->exists();
        if (!$permission) {
            return redirect()->back()->withErrors(['error' => 'Nincs letöltési jogosultságod.']);
        }

        $file = Document::findOrFail($fileId);
        $filePath = storage_path('app/public/' . $file->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $file->original_file_name);
        } else {
            return redirect()->back()->withErrors(['error' => 'A fájl nem található.']);
        }
    }

}
