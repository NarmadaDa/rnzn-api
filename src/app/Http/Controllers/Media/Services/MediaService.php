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
        $this->azureAccountName = config('queue.connections.azure.accountname');
        $this->azureAccountKey = config('queue.connections.azure.key');
    }


    public function uploadToStorage(UploadedFile $file) {
        $date = Carbon::now()->format('Y/m');
        $filename = Str::uuid()->toString(); 

        // // Create blob client.
        // $blobClient = BlobRestProxy::createBlobService("DefaultEndpointsProtocol=http;AccountName={$this->azureAccountName};AccountKey={$this->azureAccountKey};EndpointSuffix=core.windows.net"); 



        $fileName = $date.'_'.$file->getClientOriginalName();
        // save file to azure blob virtual directory uplaods in your container
        $filePath = $file->storeAs('photos/', $fileName, 'azure');



        // $fileName = time().'_'.$req->file->getClientOriginalName();
        // // save file to azure blob virtual directory uplaods in your container
        // $filePath = $req->file('file')->storeAs('uploads/', $fileName, 'azure');

    
        // $options = new CreateBlockBlobOptions;
        // $options->setContentType($file->getClientMimeType());  
        // $filePath = "$date/$filename.{$file->guessClientExtension()}";



        // $blobClient->createBlockBlob("photos", $filePath , file_get_contents($file->getPathname()), $options); 
        return [
            "file_url" => "http://{$this->azureAccountName}.blob.core.windows.net/photos/$filePath",
            "relative_file_url" => "/photos/$filePath"
        ];
    }
}