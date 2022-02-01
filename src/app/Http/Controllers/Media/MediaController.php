<?php namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Media\Services\MediaService;
use App\Http\Requests\Media\UploadRequest;
use Str;
use App\Models\Media;

class MediaController extends Controller {

    protected $mediaService;

     /**
     * Constructor
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService) {
        $this->mediaService = $mediaService;
    }

    /**
     * Handle media uploads
     * Note: This does not handle storing in the database.
     * @param UploadRequest $data
     */
    public function upload(UploadRequest $data) {
        $data->validated();
        $fileInfo = $this->mediaService->uploadToStorage($data['image']);

        $uuid = (string)Str::uuid();
        $media = Media::create([
            "uuid" => $uuid,
            "mediable_id" => 0,
            "mediable_type" => 'article',
            "type" => 'post',
            "thumbnail_url" => $fileInfo["thubnail_url"],
            "url" => $fileInfo["file_url"],
        ]);  

        return [
            "file" => $fileInfo
        ];  
    }

    /**
     * Handle media list 
    */
    public function list() {  
        // $media = Media::authorisedAccounts()->get();
        $media = Media::paginate(20);

        // return list of media
        return [
          'media_list' => $media
        ];

    
    }



}