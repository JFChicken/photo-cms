<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\PhotoProcess;

class DisplayPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$files = Storage::allFiles('public/photos');
        $data = PhotoProcess::processRecords();
        
        // foreach ($files as $file) {
            // dd($file['image'],$file['thumbnail']);
            // if (strpos($file, '.jpg') !== false) {
            //     $url = Storage::url($file);

            //     $link = "storage/thumbs/thumb{$count}.jpg";
            //     //$img = Image::make(Storage::get($file))->resize(320, 240)->save($link);
            //     $data[] = [
            //         'img' => Storage::url($file),
            //         'thumb' => $link
            //     ];
            //     $count++;
            // }
        // }
        return view('home', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
