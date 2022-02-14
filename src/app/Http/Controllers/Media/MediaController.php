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
            "file_type" => $fileInfo["file_type"],
            "dimensions" => $fileInfo["dimensions"],
            "file_size" => $fileInfo["file_size"] 
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
        $media = Media::orderBy('updated_at', 'DESC')->paginate(24);  

        // return list of media
        return [
          'media_list' => $media
        ];

    
    }

    
    /**
     * Handle media list- only images
    */
    public function onlyimg() {  
        // $media = Media::authorisedAccounts()->get();
        $media = Media::where("file_type","!=","pdf")->orderBy('updated_at', 'DESC')->paginate(24); 
        // return list of media
        return [
          'media_list' => $media
        ];

    
    }
    
    


}