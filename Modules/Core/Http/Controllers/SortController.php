<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;

class SortController extends Controller
{
    public function index(Request $request)
    {
        if ( ! $request->isXmlHttpRequest()) {
            abort('404');
        }

        $id      = $request->request->get('id');
        $new     = $request->request->get('new');
        $old     = $request->request->get('old');
        $table   = preg_replace('/[^A-z0-9-_]/', '', $request->request->get('table'));
        $cat_val = $request->request->get('cat_val', '');
        $cat     = $request->request->get('cat', '');

        $query = \DB::table($table)->where('id', '<>', $id);

        if ($cat) {
            $query->where($cat_val, $cat);
        }

//        if ($old == $new && $old != 0) {
//            die();
//        }

        \DB::table($table)->where('id', $id)->update(['pos' => $new]);

        if ($old > $new) {
            $items = $query->whereBetween('pos', [$new, $old])->orderBy('pos')->get();

            $i = $new;
            foreach ($items as $key => $item) {
                $i++;
                \DB::table($table)->where('id', $item->id)->update(['pos' => $i]);
            }
        } else {
            $items = $query->whereBetween('pos', [$old, $new])->orderBy('pos', 'DESC')->get();

            $i = $new;
            foreach ($items as $key => $item) {
                $i--;
                \DB::table($table)->where('id', $item->id)->update(['pos' => $i]);
            }
        }

		\DB::unprepared("SET @a = 0; UPDATE $table SET pos = @a:=@a+1 order by pos");
    }
}
