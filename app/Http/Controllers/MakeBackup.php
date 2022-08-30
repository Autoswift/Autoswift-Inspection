<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Storage;
use Carbon\Carbon;
Use App\Finance;
use ZipArchive;
use App\Jobs\PhotoBackup;
class MakeBackup extends Controller
{
 
    public function backup(){

        $filesInFolder = File::files(storage_path('app/Autoswift'));
        $files=[];
        foreach ($filesInFolder as $path) {
          /* $file = pathinfo($path);*/
           $file['size'] = number_format(File::size($path) / 1048576,2).' MB';
           $file['name'] = File::name($path);
           $file['extension'] = File::extension($path);
           $file['time'] = date('d-m-Y h:i:sa',filemtime($path));
           $file['create']=Carbon::parse(filemtime($path))->diffForHumans();
           $files[] = $file;
        }

        return view('Backup.index',compact('files'));   
    }
    public function fullbackup()
    {
        \Artisan::queue('backup:run');
        return back()->with('added','Backup Start Inform Shortly');
    }
    public function filebackup()
    {
        \Artisan::queue('backup:run --only-files');
        return back()->with('added','Backup Start Inform Shortly');
    }
    public function databasebackup()
    {
        \Artisan::queue('backup:run --only-db');
        return back()->with('added','Backup Start Inform Shortly');
    }
    public function downlaodbackup($filename){
        return response()->download(storage_path("app/Autoswift/{$filename}.zip"));
    }
    public function deletebackup($filename){
        unlink(storage_path('app/Autoswift/'.$filename.'.zip'));
        return back()->with('deleted','Backup Deleted Succssfully');
    }
    public function image_backup(Request $request){
        PhotoBackup::dispatch($request);
         return back()->with('added','Backup Start Inform Shortly');
        $finance=Finance::whereBetween('created_at',[date('Y-m-d',strtotime($request->form_date)),date('Y-m-d',strtotime($request->to_date))])->get();
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
        return back()->with('added','Backup Start Inform Shortly');
        //return $request->all();
    }
}
