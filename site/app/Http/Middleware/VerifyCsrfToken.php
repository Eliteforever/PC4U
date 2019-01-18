<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/addCategory',
        '/admin/editCategory',
        '/admin/deleteCategory',
        '/admin/addProperty',
        '/admin/editProperty',
        '/admin/editPropertyValue',
        '/admin/deleteProperty',
        '/admin/addProduct',
        '/admin/editProduct',
        '/admin/deleteProduct',
        '/checkout/post',
        '/admin/changeProductCategory',
        '/admin/createEditSales',
        '/admin/removeSales',
        '/selectedProductsWithCategories'
    ];
}
