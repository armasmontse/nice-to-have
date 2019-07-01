<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Language;
use Auth;

abstract class Request extends FormRequest
{
    protected $languages;
    protected $user;

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->languages_isos = Language::GetLanguagesIso();
        $this->user = Auth::user();

        parent::__construct();
    }

}
 
