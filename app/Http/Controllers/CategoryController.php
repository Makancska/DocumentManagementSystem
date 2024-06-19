<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Document;
use App\Permission;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer'
        ]);

        $category = new Category();

        $category->name = $request->input("name");
        if ($request->has('parent_id')) {
            $category->parent_id = $request->input('parent_id');

            $hasUpload = $this->hasUploadPermission($request->input('parent_id'));
            if (!$hasUpload) {
                return response()->json(['error' => 'Nincs feltöltési jogosultságod új kategória létrehozásához.'], 403);
            }
        }

        $category->save();

        return json_encode([
            "category" => $category
        ]);
    }

    public function getFilesByCategory(Request $request)
    {
        $categoryId = $request->input('categoryId');

        $files = Document::where('category_id', $categoryId)->get();

        return response()->json(['files' => $files]);
    }

    public function rename($id)
    {
        $category = Category::find($id);

        $category->name = request('name');
        $category->save();

        return json_encode([
            "category" => $category
        ]);
    }

    public function delete($id)
    {

        $hasUpload =$this->hasUploadPermission($id);
        if (!$hasUpload) {
            return response()->json(['error' => 'Nincs feltöltési jogosultságod új kategória létrehozásához.'], 403);
        }

        $category = Category::find($id);
        $this->recursiveDelete($category);

        return response()->json([
            'id' => $id
        ]);
    }

    private function recursiveDelete(Category $category)
    {
        if ($category->children()->exists()) {
            foreach ($category->children as $childCategory) {
                $this->recursiveDelete($childCategory);
            }
        }

        if ($category->files()->exists()) {
            foreach ($category->files as $file) {
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $file->delete();
            }
        }

        if ($category->permissions()->exists()) {
            $permissions = $category->permissions()->get();
            foreach ($permissions as $permission) {
                $permission->delete();
            }
        }

        $category->delete();
    }

    private function hasUploadPermission($id)
    {
        $permission = Permission::where('category_id', $id)
                                    ->where('can_upload', true)
                                    ->exists();
        return $permission;
    }

}
