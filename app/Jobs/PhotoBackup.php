<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use File;
use Storage;
use Carbon\Carbon;
Use App\Finance;
use ZipArchive;
use App\Jobs\PhotoBackup;

class PhotoBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $form_date;
    private $to_date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->form_date=$request->form_date;
        $this->to_date=$request->to_date;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $finance=Finance::whereBetween('created_at',[date('Y-m-d',strtotime($this->form_date)),date('Y-m-d',strtotime($this->to_date))])->get();
        foreach ($finance as $key => $value) {
            if(!empty($value->photo)){
                $photo=json_decode($value->photo);
                $filename = $value->registration_no.'.zip';
                $zip = new ZipArchive();
                $tmp_file = storage_path("app/temp/").$filename;
                $tmp_file_name[$key]=$filename;
                if(file_exists($tmp_file)){
                    $tmp_file= storage_path("app/temp/").$value->registration_no.'_'.$key.'.zip';
                    $tmp_file_name[$key]=$value->registration_no.'_'.$key.'.zip';
                }
                $zip->open($tmp_file, ZipArchive::CREATE);
                foreach($photo as $file){
                    if(file_exists(public_path("/finance/").$file)){
                        $download_file = file_get_contents(public_path("/finance/").$file);
                        $zip->addFromString(basename($file),$download_file);
                    }
                }
                $zip->close();
            }
        }
        $filesInFolder = File::files(storage_path('app/temp'));
        $files=[];
            $zip = new ZipArchive();
            $tmp_file = storage_path("app/Autoswift/").date('Y-m-d-h-i-s').'.zip';
                if(file_exists($tmp_file)){
                    $tmp_file= storage_path("app/temp/").date('Y-m-d-h-i-s').'.zip';   
                }
            foreach ($filesInFolder as $path) {
                $zip->open($tmp_file, ZipArchive::CREATE);
                if(file_exists($path)){
                    $download_file = file_get_contents($path);
                    $zip->addFromString(basename($path),$download_file);
                }
                File::delete($path);
            }
        $zip->close();
        return ;
    }
}
