<?php

namespace App\Helpers;
use App\Models\FloatRequirement;

class Helper
{
    public static function claimRequirements()
    {
        return FloatRequirement::orderBy('order')->get();
    }
}