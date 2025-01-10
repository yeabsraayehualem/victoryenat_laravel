<?php

namespace App\Traits;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

trait HasTimezone
{
    protected static $timezone = 'Africa/Addis_Ababa';

    protected function getLocalTime($format = null)
    {
        try {
            $time = Carbon::now(static::$timezone);
            return $format ? $time->format($format) : $time;
        } catch (\Exception $e) {
            \Log::error('Error getting local time: ' . $e->getMessage());
            return null;
        }
    }

    protected function parseLocalTime($dateTime)
    {
        try {
            if (empty($dateTime)) {
                throw new InvalidFormatException('Empty date/time string');
            }

            // Clean up the input string
            $dateTime = trim($dateTime);
            
            // If we have a date object, convert it to string first
            if ($dateTime instanceof \DateTime) {
                $dateTime = $dateTime->format('Y-m-d H:i:s');
            }

            return Carbon::parse($dateTime, static::$timezone);
        } catch (\Exception $e) {
            \Log::error('Error parsing local time: ' . $e->getMessage(), [
                'datetime' => $dateTime
            ]);
            throw $e;
        }
    }

    protected function formatLocalTime($dateTime, $format)
    {
        try {
            if (!$dateTime instanceof Carbon) {
                $dateTime = $this->parseLocalTime($dateTime);
            }
            return $dateTime->format($format);
        } catch (\Exception $e) {
            \Log::error('Error formatting local time: ' . $e->getMessage(), [
                'datetime' => $dateTime,
                'format' => $format
            ]);
            return 'Invalid Date';
        }
    }
}
