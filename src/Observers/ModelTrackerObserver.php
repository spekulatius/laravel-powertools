<?php

namespace Spekulatius\LaravelPowertools\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelTrackerObserver
{
    public function saving(Model $model)
    {
        // Get the configuration for the model class, fallback on empty
        $enabled = config('powertools.model_tracker.enabled', false);
        $config = config('powertools.model_tracker.models.'.get_class($model), []);

        // Check if tracking is enabled and there is a configuration for this model.
        // If either of them are missing, we are done already.
        if (! $enabled || count($config) === 0) {
            // !$config || is_array($config) && count($config) === 0
            return;
        }

        // Get the original attributes
        $originalAttributes = $model->getOriginal();

        // Get the updated attributes
        $updatedAttributes = $model->getAttributes();

        // Check which attributes to track
        $trackedAttributes = $config[get_class($model)];

        info(__METHOD__, [
            '$originalAttributes' => $originalAttributes,
            '$updatedAttributes' => $updatedAttributes,
            '$trackedAttributes' => $trackedAttributes,
        ]);

        // // Get the changed attributes
        // $changedAttributes = array_intersect_key($updatedAttributes, array_flip($trackedAttributes));

        // // Log the changed attributes
        // \Log::info(get_class($model) . ' #' . $model->id . ' (Update):', $changedAttributes);
    }
}
