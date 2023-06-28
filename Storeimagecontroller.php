<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\images;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Stroage;
use File;
use App\Presenters\CustomPresenter;

// use Image;

class Storeimagecontroller extends Controller{

  function index()
{
  $data = images::latest()->paginate(5);
  return view('auth.store_image', compact('data'));
}


    function insert_image(Request $request)
    // {  config(['database.default' => 'other']);
      { 
        
        $data = new images();

    $file = $request->file('file');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move('assets/', $filename);
    $data->file = $filename;

        $lor=$request->lor;
        $lorname=time().'.'.$lor->getClientOriginalExtension();
        $request->lor->move('assets/lor/',$lorname);
        $data->lor=$lorname;

        $data->name=$request->name;
        $data->certificate_no=$request->certificate_no;
        $data->certificate_year=$request->certificate_year;
        $data->c_certificate=$request->c_certificate;

        
        $komal=$request->komal;
        $filename=time().'.'.$komal->getClientOriginalExtension();
        $request->komal->move('assets/',$filename);
        $data->komal=$filename;

        $data->save();
       return redirect()->back()->with('success', 'Image store in database successfully');
      }
  
      function fetch_image($image_id)
      {
       $image = images::findOrFail($image_id);
  
       $image_file = images::make($image->file);
  
       $response = Response::make($image_file->encode('jpeg,pdf,png,jpg'));
  
       $response->header('Content-Type', 'image/jpeg');
  
       return $response;
      }
      public function download(Request $request,$file)
      {
        return response()->download('assets/'.$file);
        
      }
      public function downloadlor(Request $request,$lor)
      {
        return response()->download('assets/lor/'.$lor);
        
      }
}
  
