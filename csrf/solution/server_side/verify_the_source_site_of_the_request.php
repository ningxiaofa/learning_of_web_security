<?php

// 在服务器端验证请求来源的站点。
// 由于 CSRF 攻击大多来自于第三方站点，因此服务器可以禁止来自第三方站点的请求。
// 那么该怎么判断请求是否来自第三方站点呢？这就需要介绍 HTTP 请求头中的 Referer 和 Origin 属性了

// Referer 是 HTTP 请求头中的一个字段，记录了该 HTTP 请求的来源地址。
// 虽然可以通过 Referer 告诉服务器 HTTP 请求的来源，但是有一些场景是不适合将来源 URL 暴露给服务器的，
// 因此浏览器提供给开发者一个选项，可以不用上传 Referer 值，具体可参考 Referrer Policy。
// 但在服务器端验证请求头中的 Referer 并不是太可靠，因此标准委员会又制定了 Origin 属性，在一些重要的场合，
// 比如通过 XMLHttpRequest、Fecth 发起跨站请求或者通过 Post 方法发送请求时，都会带上 Origin 属性.


// 因此，服务器的策略是优先判断 Origin，如果请求头中没有包含 Origin 属性，再根据实际情况判断是否使用 Referer 值。3. CSRF Token



// 使用postman发送post请求
// Referer: https://time.geekbang.org/column/article/154110
// Origin: https://time.geekbang.org

// var_export($_SERVER);

// array (
//   'DOCUMENT_ROOT' => 'D:\\wamp\\php-7.4.3-Win32-vc15-x64\\public\\data_structure_and_algorithm\\链表\\PHP',
//   'REMOTE_ADDR' => '::1',
//   'REMOTE_PORT' => '61342',
//   'SERVER_SOFTWARE' => 'PHP 7.4.3 Development Server',
//   'SERVER_PROTOCOL' => 'HTTP/1.1',
//   'SERVER_NAME' => 'localhost',
//   'SERVER_PORT' => '8888',
//   'REQUEST_URI' => '/verify_the_source_site_of_the_request.php',
//   'REQUEST_METHOD' => 'POST',
//   'SCRIPT_NAME' => '/verify_the_source_site_of_the_request.php',
//   'SCRIPT_FILENAME' => 'D:\\wamp\\php-7.4.3-Win32-vc15-x64\\public\\data_structure_and_algorithm\\链表\\PHP\\verify_the_source_site_of_the_request.php',
//   'PHP_SELF' => '/verify_the_source_site_of_the_request.php',
//   'HTTP_REFERER' => 'https://time.geekbang.org/column/article/154110',
//   'HTTP_ORIGIN' => 'https://time.geekbang.org',
//   'HTTP_USER_AGENT' => 'PostmanRuntime/7.26.8',
//   'HTTP_ACCEPT' => '*/*',
//   'HTTP_CACHE_CONTROL' => 'no-cache',
//   'HTTP_POSTMAN_TOKEN' => '1333e22d-0eed-46c2-bf4f-f1612b12ce8b',
//   'HTTP_HOST' => 'localhost:8888',
//   'HTTP_ACCEPT_ENCODING' => 'gzip, deflate, br',
//   'HTTP_CONNECTION' => 'keep-alive',
//   'CONTENT_LENGTH' => '0',
//   'HTTP_CONTENT_LENGTH' => '0',
//   'REQUEST_TIME_FLOAT' => 1614673323.556021,
//   'REQUEST_TIME' => 1614673323,
//   'argv' => 
//   array (
//   ),
//   'argc' => 0,
// )

if(!empty($_SERVER['HTTP_ORIGIN']) && stripos($_SERVER['HTTP_ORIGIN'], 'localhost') === false){ // 当前域名
	header('HTTP/1.1 403 Forbidden');
	die('403');
}

if(empty($_SERVER['HTTP_ORIGIN']) && !empty($_SERVER['HTTP_REFERER']) && stripos($_SERVER['HTTP_REFERER'], 'localhost') === false){ // 当前域名
	header('HTTP/1.1 403 Forbidden');
	die('403');
}

echo 'process';
