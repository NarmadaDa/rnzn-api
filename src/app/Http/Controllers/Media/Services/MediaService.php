<?php  namespace App\Http\Controllers\Media\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class MediaService {

    protected $azureAccountName;
    protected $azureAccountKey;

    public function __construct() {
        
    }


    public function uploadToStorage(UploadedFile $file) {
        $date = Carbon::now()->format('Y-m');
        $file_name = Str::uuid()->toString(); 

        $fileName = $date.$file_name.$file->getClientOriginalName();
        // save file to azure blob virtual directory uplaods in your container
        $filePath = $file->storeAs('uploads', $fileName, 'azure'); 

        return [
            "file_url" => env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . "$filePath",
            "relative_file_url" => "$filePath"
        ];
    }
}