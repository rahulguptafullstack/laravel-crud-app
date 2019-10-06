<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contact; // contact model here
use Auth,Blade,Config,Cache,Cookie,DB,File,Hash,Mail,Redirect,Response,Session,URL,View,Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // fetch all not deleted records
      $contacts = Contact::where('is_deleted',0)->paginate(10);
      return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  		if(!empty($request)){
  			$message	=	array(
  						'first_name.required' 		=>	"Please enter first name.",
  						'first_name.regex' 				=>	"Please enter first name having alphabets only.",
  						'last_name.required' 			=>	"Please enter last name.",
  						'last_name.regex' 				 =>	"Please enter last name having alphabets only.",
  						'email.required' 				   =>	"Please enter email.",
  						'email.email' 					   =>	"Please enter a valid email.",
  						'email.unique' 					=>	"This email is already registered with us.",
  						'phone.required' 				=>	"Please enter phone number.",
  						'phone.unique' 					=>	"This phone number is already registered with us.",
              'subject.required' 				=>	"Please enter subject.",
  						'subject.regex' 				=>	"Please enter subject having alphabets only.",
              'message.required' 				=>	"Please enter message.",
  						'message.regex' 				=>	"Please enter message having alphabets only.",
  					);
  			$validate	=	array(
  					'first_name'			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
  					'last_name' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
  					'email' 				=>	'required|email|max:100|unique:contacts,email,NULL,id,is_deleted,0',
  					'phone'					=>	'required|unique:contacts,phone,NULL,id,is_deleted,0',
            'subject' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
            'message' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:255',
  				);
        if ($this->validate($request,$validate,$message)) {
          $obj 						=	new Contact;

  				$obj->first_name			=	strip_tags($request->first_name);
  				$obj->last_name				=	strip_tags($request->last_name);
          $obj->email 				  =	strip_tags($request->email);
  				$obj->phone					  =	strip_tags($request->phone);
  				$obj->subject				  =	strip_tags($request->subject);
  				$obj->message				=	strip_tags($request->message);
  				$obj->status			 =	1;
  				$obj->is_deleted			=	0;
          //print_r($obj);die;
          $obj->save();
          if($obj){
            Session::flash('success', 'Contact has been added successfully.');
    				return Redirect::route("contacts.index");
          }else {
            Session::flash('error', 'Something went wrong.');
          }
        }

  		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $contact = Contact::findOrFail($id);
      return view('contacts.edit', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $contact = Contact::findOrFail($id);
      return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if(!empty($request)){
        $message	=	array(
              'first_name.required' 		=>	"Please enter first name.",
              'first_name.regex' 				=>	"Please enter first name having alphabets only.",
              'last_name.required' 			=>	"Please enter last name.",
              'last_name.regex' 				 =>	"Please enter last name having alphabets only.",
              'email.required' 				   =>	"Please enter email.",
              'email.email' 					   =>	"Please enter a valid email.",
              'email.unique' 					=>	"This email is already registered with us.",
              'phone.required' 				=>	"Please enter phone number.",
              'phone.unique' 					=>	"This phone number is already registered with us.",
              'subject.required' 				=>	"Please enter subject.",
              'subject.regex' 				=>	"Please enter subject having alphabets only.",
              'message.required' 				=>	"Please enter message.",
              'message.regex' 				=>	"Please enter message having alphabets only.",
            );
        $validate	=	array(
            'first_name'			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
            'last_name' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
            'email' 				=>	'required|email|max:100|unique:contacts,email,'.$id.',id,is_deleted,0',
            'phone'					=>	'required|unique:contacts,phone,'.$id,'id,is_deleted,0',
            'subject' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:100',
            'message' 			=>	'required|regex:/^[\pL\s\-]+$/u|max:255',
          );
        if ($this->validate($request,$validate,$message)) {
          $obj 						=	Contact::findOrFail($id);

          $obj->first_name			=	strip_tags($request->first_name);
          $obj->last_name				=	strip_tags($request->last_name);
          $obj->email 				  =	strip_tags($request->email);
          $obj->phone					  =	strip_tags($request->phone);
          $obj->subject				  =	strip_tags($request->subject);
          $obj->message				=	strip_tags($request->message);
          $obj->status			 =	1;
          $obj->is_deleted			=	0;
          //print_r($obj);die;
          $obj->save();
          if($obj){
            Session::flash('success', 'Contact has been updated successfully.');
            return Redirect::route("contacts.index");
          }else {
            Session::flash('error', 'Something went wrong.');
          }
        }

      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $contact = Contact::findOrFail($id);
      $contact->is_deleted			=	1;
      $contact->save();
      if($contact){
        Session::flash('success', 'Contact has been deleted successfully.');
        return Redirect::route("contacts.index");
      }else {
        Session::flash('error', 'Something went wrong.');
      }
    }
}
