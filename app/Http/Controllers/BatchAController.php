<?php

namespace App\Http\Controllers;

use App\BatchA;

use Illuminate\Http\Request;

class BatchAController extends Controller
{

public function index(){
	$batchAs = BatchA::all();
	return view('admin/index', compact('batchAs'));
}

 public function create(){
 	$value = new  BatchA();
 	return view('admin/createBatchA', compact('value'));

 }
 
 public function store(){
	 $batchA = BatchA:: create($this->validateRequest());
    $this->storeImage($batchA);
 	return redirect('admin')->with('success', 'Contestant added Succefully');
 }

 public function show(BatchA $value){
 	//dd($value);
 	return view('admin/showBatchA', compact('value'));
 }

 public function edit(BatchA $value){
	$batchA = BatchA::all();
	return view('admin/editBatchA', compact('value','batchA'));

}
 public function update(BatchA $value){
  	$value->update($this->validateRequest());
  	
  	$this->storeImage($value);
  	return redirect('admin/'.$value->id);
}
public function destroy(BatchA $value){
	$value->delete();
	return redirect('admin');
}

 private function validateRequest(){
 	return tap(request()->validate([
 		'fname' => 'required',
 		'lname' => 'required',
 		'email' => 'required|email',
 		'phone' => 'required',
		'sn'    => 'required'

 		]), function(){
 		if (request()->hasFile('image')){
 			request()->validate([
 			'image'=> 'file|image|max:5000',
 			]);
 		}
 	}
 );
 }
 public function storeImage($batchA){

 	$image = (request('image'));
 	//$new_image = rand(). '.'. $image->getClientOriginalExtension();
 	//$destination = base_path(). 'public/images';
 	//$path = request('image')->move(('images'), $new_image);
 	//dd($path);
 	//dd($new_image);
 	if(request()->has('image')){
 		$new_image = rand(). '.'. $image->getClientOriginalExtension();
 		$path = request('image')->move(('images'), $new_image);
 		
 		$batchA->update(['image' =>$new_image]);
 		//dd($batchA);

 		

 		
 		//request()->image->store('public'),
 		

 		
 	}
 }
}
