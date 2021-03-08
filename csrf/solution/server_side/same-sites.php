<?php

// 1.理论知识
// 通常 CSRF 攻击都是从第三方站点发起的，要防止 CSRF 攻击，我们最好能实现从第三方站点发送请求时禁止 Cookie 的发送，
// 因此在浏览器通过不同来源发送 HTTP 请求时，有如下区别：
// 如果是从第三方站点发起的请求，那么需要浏览器禁止发送某些关键 Cookie 数据到服务器；
// 如果是同一个站点发起的请求，那么就需要保证 Cookie 数据正常发送。

// 而我们要聊的 Cookie 中的 SameSite 属性正是为了解决这个问题的，通过使用 SameSite 可以有效地降低 CSRF 攻击的风险。

// 对于防范 CSRF 攻击，我们可以针对实际情况将一些关键的 Cookie 设置为 Strict 或者 Lax 模式，
// 这样在跨站点请求时，这些关键的 Cookie 就不会被发送到服务器，从而使得黑客的 CSRF 攻击失效。

// set-cookie: 1P_JAR=2019-10-20-06; expires=Tue, 19-Nov-2019 06:36:21 GMT; path=/; domain=.google.com; SameSite=none
// SameSite 选项通常有 Strict、Lax 和 None 三个值。

// 2. PHP知识
// 方式一
// setcookie(name,value,expire,path,domain,secure);
// https://www.w3school.com.cn/php/func_http_setcookie.asp  // 具体用法

// Note:
// php 7.3版本后才可以支持SameSite属性

// 方式二:
// header('Set-Cookie: ...')

// https://stackoverflow.com/questions/39750906/php-setcookie-samesite-strict

// 3. 实践

if (PHP_VERSION_ID < 70300) {
	setcookie('samesite-test', '1', 0, '/; samesite=strict');
} else {
	header('Set-Cookie: samesite-test=1; path=/; samesite=strict')
}


// 然后浏览器中打开开发者工具, 查看响应头信息

// 封装函数
/**
 * Support samesite cookie flag in both php 7.2 (current production) and php >= 7.3 (when we get there)
 * From: https://github.com/GoogleChromeLabs/samesite-examples/blob/master/php.md and https://stackoverflow.com/a/46971326/2308553 
 *
 * @see https://www.php.net/manual/en/function.setcookie.php
 *
 * @param string $name
 * @param string $value
 * @param int $expire
 * @param string $path
 * @param string $domain
 * @param bool $secure
 * @param bool $httponly
 * @param string $samesite
 * @return void
 */
function setCookieSameSite(
    string $name, string $value,
    int $expire, string $path, string $domain,
    bool $secure, bool $httponly, string $samesite = 'None'
): void {
    if (PHP_VERSION_ID < 70300) {
        setcookie($name, $value, $expire, $path . '; samesite=' . $samesite, $domain, $secure, $httponly);
        return;
    }
    setcookie($name, $value, [
        'expires' => $expire,
        'path' => $path,
        'domain' => $domain,
        'samesite' => $samesite,
        'secure' => $secure,
        'httponly' => $httponly,
    ]);
}