<?php namespace App\Http\Helpers\Traits\Auth;

use Auth;

trait RedirectPathTrait {


    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $user = Auth::user();
        return session('CltvoPreviousURL') ? session('CltvoPreviousURL') : ($user ? $user->getHomeUrl() : "/");
    }

}
