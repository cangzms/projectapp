<?php
/**
 * Created by PhpStorm.
 * User: ubit
 * Date: 2020-12-23
 * Time: 14:28
 */

namespace App\Helpers;
use App\Models\Project;


class ProjectHelper
{
    public static function code()
    {
        do {
            $code = bin2hex(random_bytes(12));
        } while (Project::where('api_key', $code)->count() && Project::where('api_secret', $code)->count());

        return $code;
    }
}