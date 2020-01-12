<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SliderAnswer extends Model
{
    protected $table = 'slider_answers';

    protected $fillable = [
        'question_id',
        'correctValue',
        'min',
        'max',
    ];

    public function scopeOfQuestion(Builder $query, Question $question)
    {
        return $query->where('question_id', $question->id)->get();
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
