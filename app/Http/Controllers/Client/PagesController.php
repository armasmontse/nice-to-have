<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Http\Requests\Client\ContactRequest;
use App\Http\Controllers\ClientController;
use App\Http\Requests;

use App\Mail\ContactMail;
use App\Mail\ThanksForContactMail;

use App\Models\Pages\Page;

use App\Setting;

use Redirect;
use View;

class PagesController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$main_page = Page::getMainPage();
        if (!$main_page || $main_page->is_publish) {

            $data = [
                "main_page"  => $main_page,
            ];

            return view("client.pages.index",$data);
        }

        return view("client.pages.splash");
    }


	public function show(Page $public_page)
    {
        $data = [
            "public_page"  => $public_page,
        ];

        return view("client.pages.show",$data);
    }

    public function showChild(Page $public_page, Page $public_child_page)
    {

        $data = [
            "public_page"  => $public_page,
            "public_child_page"  => $public_child_page,
        ];

        return view("client.pages.show-child",$data);

    }

    public function contacto(ContactRequest $request)
    {
        $input = $request->except(['_token']);

        $full_name  = $input['full_name'];
        $email      = $input['email'];
        $phone      = $input['phone'];
        $message    = $input['message'];
        // $interest   = collect($input['interest'])->implode(', ');

        $content = [
            'Nombre: '   .$full_name,
            'Correo: '   .$email,
            'Teléfono: ' .$phone,
            '',
            $message,
            // 'Solicito información sobre como: '.$interest,
        ];

        Mail::to(Setting::getEmail('contact'))->send(new ContactMail($content, $email, $full_name));

        Mail::to($email)->send( new ThanksForContactMail($full_name) );

        return Redirect::back()->with('status', trans('pages.contact.message_received'));
    }

}
