<?php

namespace App\Http\Controllers\Admin\Cache;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Helpers\CacheHelper;

use Redirect;

class ManageCacheController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // if (isShopCacheUpdated()) {
        //     return Redirect::back()->withErrors([trans('manage_cache.update.previously')]);
        // }

        CacheHelper::updateAllAvailableCaches();

        return Redirect::back()->with('status', trans('manage_cache.update.success'));
    }

}
