<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Company;

use Illuminate\Http\Request;

class CustomersController extends Controller
{
   public function index()
   {

   	$customers = Customer::all();
   	// $activeCustomers = Customer::active()->get();
   	// $inactiveCustomers = Customer::inactive()->get();
	return view('customers/index', compact('customers'));
		#Normal Method
		//['activeCustomers'=> $activeCustomers,
		//'inactiveCustomers'=> $inactiveCustomers,]
   }

   public function create(){
   	$companies = Company::all();
   	$customer = new Customer();
   	return view('customers/create',compact('companies','customer'));
   }
  public function store(){
  	Customer::create($this->validateRequest());
   	return redirect('customers');

   }

  public function show(Customer $customer){

  	#Route model Binding by calling Model 'Customer' no need for the commented line(query) below 
  	//$customer = Customer::where('id',$customer)->firstorfail();
  	return view('customers/show', compact('customer'));
  }
public function edit(Customer $customer){
	$companies = Company::all();
	return view('customers/edit', compact('customer', 'companies'));

}
public function update(Customer $customer){
  	$customer->update($this->validateRequest());
  	return redirect('customers/'.$customer->id);
}

public function destroy(Customer $customer){
	$customer->delete();
	return redirect('customers');
}

private function validateRequest(){
		return request()->validate([
  		'name'=>'required|min:5',
  		'email'=>'required|email',
  		'active'=>'required',
  		'company_id'=>'required',
  	]);
}

}
