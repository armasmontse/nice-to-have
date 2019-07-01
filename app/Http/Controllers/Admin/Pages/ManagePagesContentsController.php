<?php

namespace App\Http\Controllers\Admin\Pages;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Pages\UpdatePagesOrderRequest;

use View;
use Response;
use Redirect;
use App\Models\Pages\Page;
use App\Publish;

use Carbon\Carbon;

class ManagePagesContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages_groups = Page::with([
                "languages",
                "publish",
                "parent",
                "childs"
            ])
            ->orderBy('main', 'DESC')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('order', 'ASC')
            ->get()
            ->groupBy(Function($page){
                return $page->main ? "00-main-page" : ($page->parent_index ? $page->parent_index : "00-principal-page") ;
            })->mapWithKeys(Function($pages){
                $page = $pages->first();
                return [
                    // no se define la key para que sea automatica
                    [
                        "parent_index"  => $page->parent_index,
                        "parent_label"  => $page->parent_label,
                        "pages"         => $pages
                    ]
                ];
            })
            ;

        $data = [
            'pages_groups' => $pages_groups,
        ];

        return view('admin.pages.contents.index', $data );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page_edit_content)
    {

        $data = [
            'page_edit'      => $page_edit_content
        ];

        return view('admin.pages.contents.edit', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sort(UpdatePagesOrderRequest $request)
    {
        $input = $request->all();

        if (!Page::whereIn("id",$input["pages"])->update(["order" => null])) {
            return Redirect::back()->withErrors(["El orden anterior no pudo ser borrado"]);
        }

        foreach ($input["pages"] as $order => $id) {
            if (!Page::where(["id"=>$id ])->update(["order" => $order])) {
                return Redirect::back()->withErrors(["El nuevo orden no pudo ser actualizado"]);
            }
        }

        return Redirect::route('admin::pages.contents.index')->with('status', "El orden se actualizó correctamente");
    }

}
