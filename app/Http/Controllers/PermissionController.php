<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|integer',
            'can_download' => 'required',
            'can_upload' => 'required'
        ]);

        $existingFile = Permission::where('category_id', $request->input("category_id"))->first();
        if ($existingFile) {
            $existingFile->can_download = $request->input("can_download");
            $existingFile->can_upload = $request->input("can_upload");
            $existingFile->save();

            return json_encode([
                "permission" => $existingFile
            ]);
        } else {
            $permission = new Permission();
            $permission->user_id = 1;
            $permission->category_id = $request->input("category_id");
            $permission->can_download = $request->input("can_download");
            $permission->can_upload = $request->input("can_upload");
            $permission->save();

            return json_encode([
                "permission" => $permission
            ]);
        }
    }

    public function show($id)
    {
        $permission = Permission::where('category_id', $id)->first();

        return response()->json(['permission' => $permission]);
    }

}
