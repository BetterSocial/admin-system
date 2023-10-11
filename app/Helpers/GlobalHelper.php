<?php

use Illuminate\Http\Request;

if (!function_exists('dataTableRequestHandle')) {

    function dataTableRequestHandle(Request $request)
    {

        $orderColumnIndex = (int) $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir', 'asc');
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 100);

        return [
            'column' => $orderColumnIndex,
            'direction' => $orderDirection,
            'start' => $start,
            'length' => $length
        ];
    }
}
