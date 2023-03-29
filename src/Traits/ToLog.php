<?php

namespace Spekulatius\LaravelPowertools\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * This helps to trim down the log spam when you are doing stuff like this:
 *
 * ```
 * \Log::error('Transmission failed', $model->toLog());
 * ```
 *
 * Any JSON data or long, multi-line strings will cause a mess.
 *
 * ToLog aims to address this by:
 *
 * - converting multi-line into single line and
 * - truncating long strings.
 */
trait ToLog
{
    public function toLog(array $data = null): array
    {
        // If no $data is provided, we are using ->toArray()
        if (is_null($data)) {
            $data = $this->toArray();
        }

        // Flat and unflat the array and tweak the content along the way...
        return Arr::undot(
            collect(Arr::dot($data))
                // Convert any Carbon instances to dates
                ->map(fn ($value) => $value instanceof Carbon ? $value->format('Y-m-d H:i:s') : $value)

                // Mask any undesirable logging keys (e.g. password, salt, etc.)
                ->maskSensitiveData()

                // Replace new lines and multi-spaces with single spaces, trim the result.
                ->map(fn ($value) => is_string($value) ? trim(preg_replace('/(\s*[\r\n]+\s*|\s+)/', ' ', $value)) : $value)

                // Shorten the length of the entries...
                ->map(fn ($value) => is_string($value) ? Str::limit($value, 30, '...') : $value)

                // Sort stuff into logical groups?
                // 1. *_id, *_at
                // 2. is_*
                // 3. rest

                // Convert back to
                ->toArray()
        );
    }
}
