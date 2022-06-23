<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class DashboardClass
{
    private $project;
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

}
