<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\Plan;
use App\Http\Controllers\Api\BaseController;

class PlanController extends BaseController
{
    public function index()
    {
        $plans = Plan::active()->ordered()->get();
        return $this->successResponse($plans);
    }

    public function show(Plan $plan)
    {
        return $this->successResponse($plan);
    }
}
