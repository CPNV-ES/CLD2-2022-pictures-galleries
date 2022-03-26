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
        $path = "phi/galleries/{$gallery->id}/" . \Str::random(40);
        $postObject = $this->createS3PostObject($path);
        return view('pictures.create', compact('gallery', 'path', 'postObject'));
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
            return redirect(\Storage::disk('s3')->temporaryUrl($picture->path, now()->addMinutes(1)));
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

    // TODO: Move this function to a global helper
    protected function createS3PostObject($key)
    {
        $awsClient = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
        ]);
        $bucket = config('filesystems.disks.s3.bucket');
        $formInputs = ['acl' => 'private', 'key' => $key];
        $options = [
            ['acl' => 'private'],
            ['bucket' => $bucket],
            ['eq', '$key', $key],
        ];
        return new \Aws\S3\PostObjectV4($awsClient, $bucket, $formInputs, $options, "+1 hours");
    }
}
