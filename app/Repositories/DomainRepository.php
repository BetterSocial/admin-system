<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface DomainRepository
{
    public function getData($domainName, $orderColumn, $orderDir, $start, $length, $draw);
    public function getDomainById($id);
    public function createDomain($req);
    public function updateDomain($req);
    public function deleteDomain($id);
}
