<?php
/**
 * Created by Developer.
 * User: Dmitry S.
 * Date: 28.11.2017
 * Time: 11:46
 */

namespace App\Repositories;

use Illuminate\Database\Connection;
use Modules\Addresses\Entities\Object;
use Modules\Pages\Entities\Pages;
use Response;

class Search
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function search($request, $text)
    {
		$addresses = Object::where('name', 'like', '%' . $text . '%')
			->orWhere('descr', 'like', '%' . $text . '%')
			->with('district')
			->get();

		$pages = Pages::where('title', 'like', '%' . $text . '%')->get();

		return compact('addresses', 'pages');
    }
}