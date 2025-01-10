<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'subject_id',
        'date',
        'time',
        'duration',
        'total_marks',
        'passing_marks',
    ];

    protected $casts = [
        'date' => 'date',
        'duration' => 'integer'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function examSheets()
    {
        return $this->hasMany(ExamSheet::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function status()
    {
        try {
            // Get current time in UTC
            $now = Carbon::now();
            
            // Convert duration to integer and ensure it's positive
            $duration = max(0, intval($this->duration));
            
            // Create start datetime
            $startDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
            
            // Calculate end time
            $endDateTime = (clone $startDateTime)->addMinutes($duration);

            if ($now < $startDateTime) {
                return 'upcoming';
            } elseif ($now >= $startDateTime && $now <= $endDateTime) {
                return 'on going';
            } else {
                return 'completed';
            }
        } catch (\Exception $e) {
            \Log::error('Error determining exam status: ' . $e->getMessage(), [
                'exam_id' => $this->id,
                'date' => $this->date,
                'time' => $this->time,
                'duration' => $this->duration
            ]);
            return 'error';
        }
    }

    public function getFormattedStartTime()
    {
        try {
            $startDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
            return $startDateTime->format('F j, Y g:i A');
        } catch (\Exception $e) {
            \Log::error('Error formatting start time: ' . $e->getMessage());
            return 'Invalid Date';
        }
    }

    public function getFormattedEndTime()
    {
        try {
            $startDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
            $endDateTime = (clone $startDateTime)->addMinutes($this->duration);
            return $endDateTime->format('F j, Y g:i A');
        } catch (\Exception $e) {
            \Log::error('Error formatting end time: ' . $e->getMessage());
            return 'Invalid Date';
        }
    }

    public function getRemainingTime()
    {
        try {
            $now = Carbon::now();
            $startDateTime = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time);
            $endDateTime = (clone $startDateTime)->addMinutes($this->duration);
            
            if ($now > $endDateTime) {
                return 0;
            }

            return $now->diffInSeconds($endDateTime);
        } catch (\Exception $e) {
            \Log::error('Error calculating remaining time: ' . $e->getMessage());
            return 0;
        }
    }

    public function isAvailableForStudent()
    {
        $status = $this->status();
        return $status === 'on going' && $this->getRemainingTime() > 0;
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function getStudentScore($userId)
    {
        $totalQuestions = $this->questions()->count();
        if ($totalQuestions === 0) {
            return 0;
        }

        $correctAnswers = $this->studentAnswers()
            ->where('user_id', $userId)
            ->where('is_correct', true)
            ->count();

        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'percentage' => ($correctAnswers / $totalQuestions) * 100
        ];
    }
}
