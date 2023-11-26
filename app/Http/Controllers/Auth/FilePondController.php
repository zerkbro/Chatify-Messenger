<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilePondController extends Controller
{
    //
    public function tempUpload(Request $request){
        if($request->file('filepond')){
            $image = $request->file('filepond');
            // Access file details
            $file_name = $image->getClientOriginalName();

            // Process the file as needed
            $folder = uniqid('message_img', true);
            $image->storeAs('public/chatify/tmp/' . $folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
                'user_id' => Auth::id(),
            ]);

            return $folder;
        }
        return '';

    }

    public function tempDelete(){
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if($tmp_file){
            // Now Deleting the Old Temporary files from the folder.
            Storage::deleteDirectory('public/chatify/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response('');
        }

    }
}
