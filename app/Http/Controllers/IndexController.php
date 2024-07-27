<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
//        DB::select("
//           SELECT
//                accounts_old.id AS old_id,
//                accounts.id AS id,
//                accounts_old.wallet_balance AS old_balance,
//                accounts.wallet_balance AS balance,
//                accounts_old.updated_at AS old_updated_at,
//                accounts.updated_at AS updated_at
//            FROM
//                accounts_old
//            LEFT JOIN
//                accounts ON accounts_old.id = accounts.id
//            WHERE
//                accounts_old.wallet_balance > accounts.wallet_balance;");
    }
}
