<?php
if(!function_exists('is_active')){
    function is_active($route_prefix)
    {
        return '/' . request()->segment(1) == $route_prefix ? '_active' :'';
    }
}

if(!function_exists('page_route')){
    function page_route($slug)
    {
        return route('page_show', $slug);
    }
}

if(!function_exists('header_lighten')){
	function header_lighten($route_prefix)
	{
		return request()->segment(1) == $route_prefix ? 'header header__lighten animated animated--top-f on' :'header animated animated--top';
	}
}

if(!function_exists('getCurrentLocale')) {
    function getCurrentLocale()
    {
        $segment = request()->segment(1);

        if (in_array($segment, config('translatable.locales'))) {

            if ($segment != config('app.fallback_locale')) return $segment;
        }
        return null;
    }
}

if (!function_exists('notifyTelegram')) {
    function notifyTelegram($message)
    {
        $message = str_replace(array("%0A"), '', $message);
        $chat_id = config('telegram.chat_id');
        $token = config('telegram.token');
        
        $res = shell_exec(`curl -X POST \
         -H 'Content-Type: application/json' \
         -d '{"chat_id": "$chat_id", "parse_mode": "html", "text": "$message", "disable_notification": true}' \
         https://api.telegram.org/bot$token/sendMessage`);
         
        // $url = "https://api.telegram.org/bot" . config('telegram.token') . "/sendMessage?chat_id=" . config('telegram.chat_id') . "&parse_mode=html";
        // $url = $url . "&text=" . $message;
        // $ch = curl_init();
        // $optArray = array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_PORT => 6969
        // );
        // curl_setopt_array($ch, $optArray);
        // curl_exec($ch);
        // curl_close($ch);

        return true;
    }
}