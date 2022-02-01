<?php namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Media\Services\MediaService;
use App\Http\Requests\Media\UploadRequest;
use App\Models\Media;
use App\Http\Controllers\PaginatedController;
use DB;
use Illuminate\Support\Str;

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

        DB::beginTransaction();

        try { 
            $fileInfo = $this->mediaService->uploadToStorage($data['image']); 
 
            $uuid = (string)Str::uuid();
            $media = Media::create([
                "uuid" => $uuid,
                "type" => '',
                "mediable_id" => 1,
                "mediable_type" => 'menu_item',
                "type" => 'banner',
                "thumbnail_url" => $fileInfo["file_url"],
                "url" => $fileInfo["file_url"],
            ]);

            return [
                "file" => $fileInfo
            ];
            
        } catch (Exception $e) {
            DB::rollback();
            abort(500, $e->getMessage());
        }

    
    }



    /**
     * Handle media list 
    */
    // public function list() {    
    //     // $media = Media::authorisedAccounts()->get();

    //     $perPage = 10;
    //     // $media = Media::get();

    //     // // return list of media
    //     // return [
    //     //   'media_list' => $media
    //     // ];


    //     $uuid = (array)'78650e9f-3cfe-4144-8b71-d60d5bab7b16';
    //     $posts = Media::whereIn("uuid", $uuid)
    //     ->orderByDesc("updated_at");

    //     return [
    //           'media_list' => $posts
    //         ];
    // //   $paginated = $posts->paginate($perPage);
  
    //   // return list of filtered media
    // //   return $this->paginate("media_list", $paginated);
    
    // }
}