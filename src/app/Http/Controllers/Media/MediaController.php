<?php namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Media\Services\MediaService;
use App\Http\Requests\Media\UploadRequest;

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
        return [
            "file" => $fileInfo
        ];
    }

}