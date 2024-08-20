<?php

namespace Modules\Core\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Core\Entities\Settings;
use Modules\Core\Http\Forms\IndexForm;

class IndexController extends Controller
{
    use FormBuilderTrait;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Settings $settings, FormBuilder $form_builder, Request $request)
    {

        $date = Carbon::now();
        $period = 'day';
        $days = [];

        if ($request->get('newPlayers')) {
            $period = $request->get('newPlayers');
        }

        switch($period) {
            case "day":
                $days_count = 24;
                break;
            case "week":
                $days_count = 14;
                break;
            case "month":
                $days_count = 31;
                break;
            case "year":
                $days_count = 12;
                break;
        }

        for ($i = 0; $i < $days_count; $i++) {
            switch($period) {
                case "day":
                    $startOfDay = $date->copy()->format('Y-m-d H:00:00');
                    $endOfDay = $date->format('Y-m-d H:59:59');
                    $formattedDate = $date->format('d M H:00');
                    $formattedDay = $date->format('d M H:00');
                    break;
                case "week":
                    $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
                    $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('d M');
                    break;
                case "month":
                    $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
                    $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('d M');
                    break;
                case "year":
                    $startOfDay = $date->startOfDay()->format('Y-m-01');
                    $endOfDay = $date->endOfDay()->format('Y-m-31');
                    $formattedDate = $date->format('Y-m-d');
                    $formattedDay = $date->format('M');
                    break;
            }

            $telegramCount = DB::selectOne('
                SELECT COUNT(CASE WHEN id_telegram IS NOT NULL THEN 1 END) as count 
                FROM accounts 
                WHERE created_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $webCount = DB::selectOne('
                SELECT COUNT(CASE WHEN id_telegram IS NULL THEN 1 END) as count 
                FROM accounts 
                WHERE created_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $days[] = [
                'date' => $formattedDate,
                'day' => $formattedDay,
                'telegram' => $telegramCount,
                'web' => $webCount
            ];

            switch($period) {
                case "day":
                    $date->subHour();
                    break;
                case "week":
                    $date->subDay();
                    break;
                case "month":
                    $date->subDay();
                    break;
                case "year":
                    $date->subMonth();
                    break;
            }
        }

        $date = Carbon::now();
        $days_count = 14;
        $gaming = [];

        for ($i = 0; $i < $days_count; $i++) {
            $startOfDay = $date->startOfDay()->timestamp;
            $endOfDay = $date->endOfDay()->timestamp;
            $formattedDate = $date->format('Y-m-d');
            $formattedDay = $date->format('d M');

            // Запрос для Telegram пользователей
            $telegramCount = DB::selectOne('
                SELECT COUNT(id) as count 
                FROM accounts 
                WHERE id_telegram IS NOT NULL  
                AND update_balance_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            // Запрос для Web пользователей
            $webCount = DB::selectOne('
                SELECT COUNT(id) as count 
                FROM accounts 
                WHERE id_telegram IS NULL 
                AND update_balance_at BETWEEN ? AND ?
            ', [$startOfDay, $endOfDay])->count;

            $gaming[] = [
                'date' => $formattedDate,
                'day' => $formattedDay,
                'telegram' => $telegramCount,
                'web' => $webCount
            ];

            // Переход на предыдущий день
            $date->subDay();
        }

//        $date = Carbon::now();
//        $days_count = 14;
//        $players = [];
//
//        for ($i = 0; $i < $days_count; $i++) {
//            $startOfDay = $date->startOfDay()->format('Y-m-d H:i:s');
//            $endOfDay = $date->endOfDay()->format('Y-m-d H:i:s');
//            $startOfDayTime = $date->startOfDay()->timestamp;
//            $formattedDate = $date->format('Y-m-d');
//            $formattedDay = $date->format('d M');
//
//            // Запрос для Telegram пользователей
//            $telegramCount = DB::selectOne('
//                SELECT COUNT(id) as count
//                FROM accounts
//                WHERE id_telegram IS NOT NULL
//                AND update_balance_at > ?
//                AND id in (SELECT account_id from accounts_daily_quests where created_at BETWEEN ? AND ?)
//            ', [$startOfDayTime, $startOfDay, $endOfDay])->count;
//
//            // Запрос для Web пользователей
//            $webCount = DB::selectOne('
//                SELECT COUNT(id) as count
//                FROM accounts
//                WHERE id_telegram IS NULL
//                AND update_balance_at > ?
//                AND id in (SELECT account_id from accounts_daily_quests where created_at BETWEEN ? AND ?)
//            ', [$startOfDayTime, $startOfDay, $endOfDay])->count;
//
//            $players[] = [
//                'date' => $formattedDate,
//                'day' => $formattedDay,
//                'telegram' => $telegramCount,
//                'web' => $webCount
//            ];
//
//            // Переход на предыдущий день
//            $date->subDay();
//        }

        $currentTime = time();
        $callDownAccounts = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE active_at > ? 
            AND energy = 0
        ', [$currentTime])->count;

        $decHour = Carbon::now()->timestamp;

        $callDownAccountsNotNotified = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE active_at IS NOT NULL
            AND active_at < ' . $decHour . '
            AND id_telegram IS NOT NULL 
            AND energy = 0 
            AND notify_play = 0
        ')->count;

        $callDowntNotifyJobs = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM jobs 
        ')->count;

        $callDownAccountsNotified = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE active_at IS NOT NULL 
            AND id_telegram IS NOT NULL 
            AND energy = 0 
            AND notify_play = 1
        ')->count;

        $today = Carbon::today();
        $startOfDay = $today->startOfDay()->timestamp;
        $endOfDay = $today->endOfDay()->timestamp;

        $nowPlaying = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE update_balance_at BETWEEN ? AND ?
        ', [$startOfDay, $endOfDay])->count;

        $lastHour = Carbon::now()->subHour()->timestamp;
        $lastHourPlaying = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE update_balance_at > ?
        ', [$lastHour])->count;

        $lastMinute = Carbon::now()->subMinute()->timestamp;
        $lastMinutePlaying = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE update_balance_at > ?
        ', [$lastMinute])->count;

        $neverPlaying = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE energy = 0 
            AND wallet_balance = 0 
            AND active_at IS NULL
        ')->count;

        $hasWallet = DB::selectOne('
            SELECT COUNT(id) as count 
            FROM accounts 
            WHERE wallet_address IS NOT NULL
        ')->count;

        $values = $settings->allParams();
        $values['main'] = [
            'site_logo' => $values['site_logo'] ?? '',
            'site_h1' => $values['site_h1'] ?? '',
            'site_subtitle' => $values['site_subtitle'] ?? '',
            'site_energy_info' => $values['site_energy_info'] ?? '',
            'site_char_image' => $values['site_char_image'] ?? '',
            'site_game_link_name' => $values['site_game_link_name'] ?? '',
            'site_game_link' => $values['site_game_link'] ?? '',
            'site_game_bot_link_name' => $values['site_game_bot_link_name'] ?? '',
            'site_game_bot_link' => $values['site_game_bot_link'] ?? '',
            'site_about_descr1' => $values['site_about_descr1'] ?? '',
            'site_about_image1' => $values['site_about_image1'] ?? '',
            'site_about_descr2' => $values['site_about_descr2'] ?? '',
            'site_about_image2' => $values['site_about_image2'] ?? '',
            'site_features_title' => $values['site_features_title'] ?? '',
            'site_features_subtitle' => $values['site_features_subtitle'] ?? '',
            'site_features_image' => $values['site_features_image'] ?? '',
            'site_bot_link_name' => $values['site_bot_link_name'] ?? '',
            'site_bot_link' => $values['site_bot_link'] ?? '',
            'site_follow_us' => $values['site_follow_us'] ?? '',
            'site_utility_title' => $values['site_utility_title'] ?? '',
            'site_befriend_title' => $values['site_befriend_title'] ?? '',
            'site_befriend_subtitle' => $values['site_befriend_subtitle'] ?? '',
            'site_gold_char_image' => $values['site_gold_char_image'] ?? '',
            'site_solana_fam_link_name' => $values['site_solana_fam_link_name'] ?? '',
            'site_solana_fam_link' => $values['site_solana_fam_link'] ?? '',
            'site_footer_descr' => $values['site_footer_descr'] ?? '',
            'site_footer_char_img' => $values['site_footer_char_img'] ?? '',
            'site_footer_copy' => $values['site_footer_copy'] ?? '',
        ];

        $values['game'] = [
            'mainContent__title' => $values['mainContent__title'] ?? '',
            'mainContent__descr' => $values['mainContent__descr'] ?? '',
            'header__inviteBtn' => $values['header__inviteBtn'] ?? '',
            'header__leaderboard' => $values['header__leaderboard'] ?? '',
            'mainContent__refFriends' => $values['mainContent__refFriends'] ?? '',
            'mainContent__petCat' => $values['mainContent__petCat'] ?? '',
            'mainContent__earnPoins' => $values['mainContent__earnPoins'] ?? '',
            'mainContent__energyHint' => $values['mainContent__energyHint'] ?? '',
            'maximumEnergy' => $values['maximumEnergy'] ?? '',
            'header__totalScore' => $values['header__totalScore'] ?? '',
            'popupInvite__content_title' => $values['popupInvite__content_title'] ?? '',
            'popupInvite__header_title' => $values['popupInvite__header_title'] ?? '',
            'popupInvite__bonus_title' => $values['popupInvite__bonus_title'] ?? '',
            'popupInvite__ref_friends_title' => $values['popupInvite__ref_friends_title'] ?? '',
            'popupInvite__step1' => $values['popupInvite__step1'] ?? '',
            'popupInvite__step2' => $values['popupInvite__step2'] ?? '',
            'popupInvite__step3' => $values['popupInvite__step3'] ?? '',
            'popupInvite__ref_link_title' => $values['popupInvite__ref_link_title'] ?? '',
            'popupInvite__submit' => $values['popupInvite__submit'] ?? '',
            'mainContent__startBtn' => $values['mainContent__startBtn'] ?? '',
            'mainContent__backBtn' => $values['mainContent__backBtn'] ?? '',
            'twitter_connect_price' => $values['twitter_connect_price'] ?? '',
            'tg_chat_connect_price' => $values['tg_chat_connect_price'] ?? '',
            'tg_channel_connect_price' => $values['tg_channel_connect_price'] ?? '',
            'website_connect_price' => $values['website_connect_price'] ?? '',
            'wallet_connect_price' => $values['wallet_connect_price'] ?? ''
        ];

        $values['game_images'] = [
            '1_idle' => $values['1_idle'] ?? '',
            '1talk' => $values['1talk'] ?? '',
            '2_idle' => $values['2_idle'] ?? '',
            '2talk' => $values['2talk'] ?? '',
            '3_idle' => $values['3_idle'] ?? '',
            '3talk' => $values['3talk'] ?? '',
            '4_idle' => $values['4_idle'] ?? '',
            '4talk' => $values['4talk'] ?? '',
            'finalForm' => $values['finalForm'] ?? '',
            'gold' => $values['gold'] ?? '',
            'cat_coin' => $values['cat_coin'] ?? '',
            'boost_coin' => $values['boost_coin'] ?? '',
            'talk_sound' => $values['talk_sound'] ?? '',
            'boost_sound' => $values['boost_sound'] ?? '',
            'bgFirst' => $values['bgFirst'] ?? '',
            'bgSecond' => $values['bgSecond'] ?? '',
            'bgThird' => $values['bgThird'] ?? '',
            'bgFourth' => $values['bgFourth'] ?? '',
            'bgFives' => $values['bgFives'] ?? ''
        ];

        $values['bot'] = [
            'intro_image' => $values['intro_image'] ?? '',
            'intro' => $values['intro'] ?? '',
            'rules_image' => $values['rules_image'] ?? '',
            'rules' => $values['rules'] ?? '',
            'referral_image' => $values['referral_image'] ?? '',
            'referral' => $values['referral'] ?? '',
            'stay_tuned_image' => $values['stay_tuned_image'] ?? '',
            'stay_tuned' => $values['stay_tuned'] ?? '',
            'profile_image' => $values['profile_image'] ?? '',
        ];

        $form = $form_builder->create(IndexForm::class,[
            'method' => 'POST',
            'url' => route('admin.store'),
            'model' => $values
        ]);

        return view('core::index', compact(
            'form',
            'callDownAccounts',
            'callDownAccountsNotNotified',
            'callDownAccountsNotified',
            'callDowntNotifyJobs',
            'nowPlaying',
            'lastHourPlaying',
            'lastMinutePlaying',
            'neverPlaying',
            'hasWallet',
            'days',
            'gaming',
//            'players'
        ));
    }

    public function store(Settings $settings)
    {
        $form = $this->form(IndexForm::class);

        $form->redirectIfNotValid();

        $values = $form->getFieldValues();

        $main = $values['main'];
        unset($values['main']);
        $values += $main;

        $game = $values['game'];
        unset($values['game']);
        $values += $game;

        $game_images = $values['game_images'];
        unset($values['game_images']);
        $values += $game_images;

        $bot = $values['bot'];
        unset($values['bot']);
        $values += $bot;

        $settings->updateParams($values);

        return redirect()->route('admin.index');
    }
}
