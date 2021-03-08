<?php

// 除了使用以上两种方式来防止 CSRF 攻击之外，
// 还可以采用 CSRF Token 来验证，
// 这个流程比较好理解，大致分为两步。
// 第一步，在浏览器向服务器发起请求时，服务器生成一个 CSRF Token。
// CSRF Token 其实就是服务器生成的字符串，然后将该字符串植入到返回的页面中。
// 你可以参考下面示例代码：

// <!DOCTYPE html>
// <html>
// <body>
//     <form action="https://time.geekbang.org/sendcoin" method="POST">
//       <input type="hidden" name="csrf-token" value="nc98P987bcpncYhoadjoiydc9ajDlcn">
//       <input type="text" name="user">
//       <input type="text" name="number">
//       <input type="submit">
//     </form>
// </body>
// </html>

// 第二步，在浏览器端如果要发起转账的请求，那么需要带上页面中的 CSRF Token，
// 然后服务器会验证该 Token 是否合法。
// 如果是从第三方站点发出的请求，那么将无法获取到 CSRF Token 的值，-----> 可以想下为什么它获取不到token
// 所以即使发出了请求，服务器也会因为 CSRF Token 不正确而拒绝请求。


// 获取请求带的token [可能通过header也可能通过body]
// 这里以post请求, body中带上token的方式
if($_POST['csrf_token'] !== '1333e22d-0eed-46c2-bf4f-f1612b12ce8b'){ // 后者是服务器生成, 并且存放服务器中, 同时返回给浏览器的. // 例如, Laravel 会自动为每一个被应用管理的有效用户会话生成一个 CSRF “令牌”，然后将该令牌存放在 Session 中，该令牌用于验证授权用户和发起请求者是否是同一个人。 中间件组 web 中的中间件 VerifyCsrfToken 会自动为我们验证请求输入的 token 值和 Session 中存储的 token 是否一致，如果没有传递该字段或者传递过来的字段值和 Session 中存储的数值不一致，则会抛出异常。
	die('403');
}

// Note:
// 针对于请求的，比如同一个浏览器打开两个相同页面，那么服务器为这两个页面生成的csrf token都是不同的

echo 'process';

