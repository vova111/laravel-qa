<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function index(Question $question)
    {
        $answers = $question->answers()->with('user')->simplePaginate(3);

        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Question $question, Request $request)
    {
        $answer = $question->answers()->create($request->validate([
            'body' => 'required',
        ]) + ['user_id' => \Auth::id()]);

        return response()->json([
            'message' => "Your answer has been submitted successfully",
            'answer' => new AnswerResource($answer->load('user')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        return response()->json([
            'message' => 'Your answer has been updated',
            'body_html' => $answer->body_html,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json([
            'message' => 'You answer has been removed',
        ]);
    }
}
