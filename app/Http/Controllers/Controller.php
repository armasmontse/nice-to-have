<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use View;

use App\Language;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * autenficacion de usuario
     * @var \App\User|null
     */
    protected $user;

    /**
     * 	si el usuario esta logeado
     *
     * @var \App\User|null
     */
    protected $signedIn;


    /**
     * si el usuario es super admin
     *
     * @var boolean
     */
    protected $userIsSuperAdmin = false;

    /**
     * arreglo de setting que se cargaran con la pagina
     *
     * @var array
     */
    protected $settings = [
        // "key"   => null
    ];

// protected $languages;
// protected $current_language;

    /**
     * crea un nuevo controlador
     */
    public function __construct(){

        $this->middleware(function ($request, $next) {
            $this->reconstructController();

            if (method_exists($this,"constructThisController")  ) {
                $this->constructThisController();
            }

            return $next($request);
        });
    }

    private function reconstructController()
    {
    // usuario logueado
        $this->user = $this->signedIn = Auth::user(); // usuario logueado
        View::share("user",$this->user); // pasar a todas las vistas

    // super Admin
        $this->userIsSuperAdmin = $this->user ? $this->user->isSuperAdmin() : false;

    // idiomas
        $current_lang_iso =  session("lang") ? session("lang") : "es"  ;
        View::share("current_lang_iso",$current_lang_iso); // pasar a todas las vistas

        $this->current_language = Language::where(['iso6391' => $current_lang_iso])->first();
    //
        $this->languages = Language::all();
        View::share("languages",$this->languages); // pasar a todas las vistas
    //
    // // carga los settings de la pagina
    //     foreach ( $this->settings as $settingKey => $setting ) {
    //         // $this->settings[$settingKey] = Setting::getSetting($settingKey);
    //     }
    }

}
