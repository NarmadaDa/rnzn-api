<?php  namespace App\Http\Controllers\Media\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
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
 
        // Get File Size
        $bytes = $file->getSize(); 
        $file_size = number_format($bytes / 1024, 2) . ' KB';  

        if($file_type == 'pdf'){

            $dimensions = '';

            $filePath = $file->storeAs('pdf', $fileName, 'azure'); 
            $thumbnailfilePath = '/thumbnail/pdf-default.jpeg'; 
            $file_url = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . "$filePath";
            $thubnail_url = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . "$thumbnailfilePath";

        } else if($file_type == 'jfif'){
            $file_type = 'jfif';
            $dimensions = '';
            $file_size = '';
            $file_url = '';
            $thubnail_url = '';
            $filePath = ''; 
        } else { 
            // Make Thumbnail - crop the best fitting 1:1 ratio (300x300) and resize to 300x300 pixel
            $resize = Image::make($file)->fit(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('png');   
    
            // save file to azure blob virtual directory uplaods in your container
            $filePath = $file->storeAs('uploads', $fileName, 'azure'); 

            
            // Get Dimensions
            $image = getimagesize( env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' .$filePath);
            $width = $image[0];
            $height = $image[1];
            $dimensions = $width . 'px * ' .$height.'px'; 
    
            $azure = Storage::disk('azure');
            $thumbnailfilePath = '/thumbnail/' . $fileName;
            $azure->put($thumbnailfilePath, $resize); 
 
            $file_url = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . "$filePath";
            $thubnail_url = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . "$thumbnailfilePath";
          
        }

        $uploded_media = [
            "file_type" => $file_type,
            "dimensions" =>  $dimensions, 
            "file_size" =>  $file_size,
            "file_url" => $file_url,
            "thubnail_url" => $thubnail_url,
            "relative_file_url" => $filePath
        ];

        return $uploded_media;
    }
}