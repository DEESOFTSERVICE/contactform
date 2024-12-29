<?php

namespace Deepak\Contactform\Http\Controllers;

use Deepak\Contactform\Mail\ContactMail;
use Deepak\Contactform\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends BaseController
{
    public function create()
    {
        return view("contactform::create");
    }

    public function save(Request $request)
    {
        $validated  = $request->validate([
            'name'  =>  'required|min:4',
            'email' =>  'required|email',
            'subject'   => 'required|min:6',
            'message'   =>  'required|min:6'
        ]);

        Contacts::create($validated);

        // send email
        $admin_email = config("contactform.admin_email");
        if ($admin_email === null || $admin_email === "") {
            echo "please set admin email in app/config/contactform.php";
        } else {
            Mail::to($validated['email'])->send(new ContactMail($validated));
        }

        return redirect()->back()->with('message', 'Contact Save Successfully');
    }
}
