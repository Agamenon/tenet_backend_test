<?php

namespace App\Models\Traits;

use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

trait HasCustomEventsLogs
{
    public static $DEACTIVATED = 'deactivated';

    public static $ACTIVATED = 'activated';

    public static $DELETED = 'deleted';

    public static $RESTORED = 'restored';

    public static $CREATED = 'created';

    public static $UPDATED = 'updated';

    abstract protected function getHumanModelName(): string;

    /**
     * Observer envent Log Activity
     *
     * @return void
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        if ($eventName === self::$DELETED) {
            $forceDelete = (method_exists($activity->subject, 'isForceDeleting')) ? (bool) $activity->subject->isForceDeleting() : false;
            $activity->event = ($forceDelete) ? $eventName : self::$DEACTIVATED;
            $eventDescription = ($forceDelete) ? $eventName : self::$DEACTIVATED;
            $activity->description = "This {$activity->subject->getHumanModelName()} has been $eventDescription";
        }

        if ($eventName === self::$RESTORED) {
            $activity->event = self::$ACTIVATED;
            $activity->description = "This {$activity->subject->getHumanModelName()} has been ".self::$ACTIVATED;
        }
    }

    /**
     * Setup Audit Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => "This {$this->getHumanModelName()} has been {$eventName}")
            ->useLogName('audit')
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
