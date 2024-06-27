<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

function canAccess($param)
{
    if (auth()->user()->role == 'CUSTOMER') {
        return false;
    }
    if (empty($param)) {
        return true;
    }
    return app()->globalPermissions->first(function ($value) use ($param) {
        return $value === $param;
    });
};
