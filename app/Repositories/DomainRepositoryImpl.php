<?php

namespace App\Repositories;

use App\Models\Domain;
use Illuminate\Http\Request;

class DomainRepositoryImpl implements DomainRepository
{
    public function getData($domainName, $orderColumn, $orderDir, $start, $length, $draw)
    {
        // Define columns
        $columns = array(
            0 => 'domain_page_id',
            1 => 'domain_name',
            2 => 'logo',
            3 => 'short_description',
            4 => 'created_at',
            5 => 'updated_at',
            6 => 'status',
        );

        // Base query
        $query = Domain::query();

        // Add domain name condition if it exists
        if ($domainName != null) {
            $query->where('domain_name', 'like', '%' . $domainName . '%');
        }

        // Get total count
        $total = $query->count();

        // Add order, limit and offset to the query
        $query->orderBy($columns[$orderColumn], $orderDir)
            ->skip($start)
            ->take($length);

        // Get limited data
        $dataLimit = $query->get();

        return [
            'draw'            => $draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ];
    }

    public function getDomainById($id)
    {
        return Domain::find($id);
    }

    public function createDomain($req)
    {
        $domain = new Domain();
        $domain->domain_name = $req->domainName;
        $domain->logo = $req->logo;
        $domain->short_description = $req->shortDescription;
        $domain->save();
    }

    public function updateDomain($req)
    {
        $domain = Domain::find($req->domainPageId);
        $domain->domain_name = $req->domainName;
        $domain->logo = $req->logo;
        $domain->short_description = $req->shortDescription;
        $domain->save();
    }

    public function deleteDomain($id)
    {
        $domain = Domain::find($id);
        $domain->delete();
    }
}
