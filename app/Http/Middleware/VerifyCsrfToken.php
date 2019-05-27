<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

        //
        '/createOrder',
        '/ordershow',
        '/pay/*',
        'cartAdd',
        'goods/goodsDetail',
        'logins',
<<<<<<< HEAD
        'weixin'
=======
        'tel'
>>>>>>> c496651fcb9c86b5665d535bc084d5ab016a3756
    ];
}
