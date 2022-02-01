<?php  namespace App\Http\Controllers\Media\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use Image;  

class MediaService {

    protected $azureAccountName;
    protected $azureAccountKey;

    public function __construct() {
        
    }


    public function uploadToStorage(UploadedFile $file) {
        $date = Carbon::now()->format('Y-m');
        $file_name = Str::uuid()->toString(); 

        $fileName = $date.$file_name.$file->getClientOriginalName(); 

        $file_type  = $file->getClientOriginalExtension();  
        if($file_type == 'pdf'){

            $filePath = $file->storeAs('pdf', $fileName, 'azure'); 

            $uploded_media = [
                "file_url" => env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . "$filePath",
                "thubnail_url" => "",
                "relative_file_url" => "$filePath"
            ];

        } else { 
            // Make Thumbnail
            $resize = Image::make($file)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg');  
    
            // save file to azure blob virtual directory uplaods in your container
            $filePath = $file->storeAs('uploads', $fileName, 'azure'); 
    
            $azure = Storage::disk('azure');
            $thumbnailfilePath = '/thumbnail/' . $fileName;
            $azure->put($thumbnailfilePath, $resize);
 
            $uploded_media = [
                "file_url" => env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . "$filePath",
                "thubnail_url" => env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . "$thumbnailfilePath",
                "relative_file_url" => "$filePath"
            ];
        }

        return $uploded_media;
    }
}