<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Gallery $gallery)
    {
        $pictures = $gallery->pictures;
        return view('pictures.index', compact('pictures', 'gallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Gallery $gallery)
    {
        return view('pictures.create', compact('gallery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Gallery $gallery, Request $request)
    {
        $picture = new Picture($request->all());
        $picture->gallery()->associate($gallery);

        $picture->path = $request->file('picture_file')->store(
            'galleries/'.$gallery->id, 'local'
        );

        $picture->save();

        return redirect()->route('galleries.pictures.index', $gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery, Picture $picture, Request $request)
    {
        if (\Str::startsWith($request->header('Accept'), 'image/')) {
            return \Storage::download($picture->path);
        } else {
            return view('pictures.show', compact('picture', 'gallery'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
