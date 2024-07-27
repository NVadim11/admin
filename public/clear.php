<?php

echo phpinfo(); exit(); 
	$output = shell_exec('
		/usr/bin/php8.1 artisan cache:clear
        /usr/bin/php8.1 artisan view:clear
        /usr/bin/php8.1 artisan route:clear
        /usr/bin/php8.1 artisan clear-compiled
        /usr/bin/php8.1 artisan config:cache
	');
	
	echo "<pre>$output</pre>";
?>
