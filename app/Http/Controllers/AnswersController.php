<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Resources\AnswerResource;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        $answers = $question->answers()
            ->with('user')
            ->where(function ($q) {
                if (request()->has('excludes')) {
                    $q->whereNotIn('id', request()->query('excludes'));
                }
            })
            ->simplePaginate(3);

        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, Request $request)
    {
        $answer = $question->answers()->create($request->validate([
            'body' => 'required',
        ]) + ['user_id' => \Auth::id()]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "Your answer has been submitted successfully",
                'answer' => $answer->load('user'),
            ]);
        }

        return back()->with('success', 'You answer has been submitted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view("answers.edit", compact("question", "answer"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html,
            ]);
        }

        return redirect()->route("questions.show", $question->slug)->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'You answer has been removed',
            ]);
        }

        return back()->with("success", "You answer has been removed");
    }
}
