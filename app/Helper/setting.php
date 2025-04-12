<?php

namespace App\Helper;

use App\Models\Setting as SettingModel;
class Setting
{
    public function isAutoRecalculate()
    {
        return filter_var(SettingModel::where('key', 'auto_recalculate')->value('value'), FILTER_VALIDATE_BOOLEAN);
    }
}