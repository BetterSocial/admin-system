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


if (!function_exists('limitOrderQuery')) {

    function limitOrderQuery(Request $request, $query, $columns)
    {

        $dataTable = dataTableRequestHandle($request);
        $query->orderBy($columns[$dataTable['column']], $dataTable['direction'])
            ->offset($dataTable['start'])
            ->limit($dataTable['length']);

        return $query;
    }
}
