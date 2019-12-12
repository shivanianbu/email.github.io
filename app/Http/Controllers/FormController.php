<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FormMultipleUpload;

class FormController extends Controller
{
    public function index()
    {
        $data = FormMultipleUpload::all();
        return view('form_upload',compact('data'));
    }

    public function store()
    {
        $this->validate($request,[
            'filename'=>'required',
            'filename.*'=>'image|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);
    }
}
