<?php

namespace Spekulatius\LaravelPowertools\Observers;

use Illuminate\Database\Eloquent\Model;

class VariableTrackerObserver
{
    public function saving(Model $model)
    {
        // Get the configuration for the model class
        $config = config('variable-tracker.' . get_class($model), []);

        // Check if tracking is enabled for this model and there is something.
        if (!$config || is_array($config) && count($config) === 0) {
            return;
        }

        // Get the original attributes
        $originalAttributes = $model->getOriginal();

        // Get the updated attributes
        $updatedAttributes = $model->getAttributes();


        // Check which attributes to track
        $trackedAttributes = $config['attributes'];

        // Get the changed attributes
        $changedAttributes = array_intersect_key($updatedAttributes, array_flip($trackedAttributes));

        // Log the changed attributes
        foreach ($changedAttributes as $attribute => $value) {
            // Log the change or perform any other desired action
        }
    }
}
