<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivity;

trait LogsActivity
{
    use BaseLogsActivity {
        BaseLogsActivity::activities as baseActivites;
    }

    public function activities(): MorphMany
    {
        return $this->baseActivites()
            ->with('causer')
            ->latest(App::environment('testing') ? 'id' : 'created_at');
    }
}
