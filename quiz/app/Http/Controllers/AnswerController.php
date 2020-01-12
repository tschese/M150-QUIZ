<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\SliderAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    /**
     * AnswerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Answer::class, 'answer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::all();
        return response($answers);
    }

    public function indexForQuestion(Question $question)
    {
        $answers = Answer::ofQuestion($question);
        $sliderAnswers = SliderAnswer::ofQuestion($question);
        $content = array($answers);
        array_push($content, $sliderAnswers);
        return response($content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'answerText' => 'required',
            'isCorrect' => 'required'
        ]);

        $answer = new Answer([
            'question_id' => $request->get('question_id'),
            'answerText' => $request->get('answerText'),
            'isCorrect' => $request->get('isCorrect'),
        ]);

        $answer->save();

        return response(null, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeSliderAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'correctValue' => 'required',
            'min' => 'required',
            'max' => 'required',
        ]);

        $sliderAnswer = new SliderAnswer([
            'question_id' => $request->get('question_id'),
            'correctValue' => $request->get('correctValue'),
            'min' => $request->get('min'),
            'max' => $request->get('max'),
        ]);

        $sliderAnswer->save();

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return response($answer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'question_id' => 'required',
            'answerText' => 'required',
            'isCorrect' => 'required'
        ]);

        $answer->fill($request->all());
        $answer->save();

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response(null, 204);
    }
}