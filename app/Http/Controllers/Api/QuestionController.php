<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allQuestion = Question::where('form_no', 2)->get();
        return QuestionResource::collection($allQuestion);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $questions = json_decode($request->questions, true);
        // Question::where('form_no', 2)->delete();
        foreach ($questions as $question) {
            Question::updateOrCreate([
                'id' => $question['id'],
                'form_no' => 2,
                'step' => $question['step'],
                'sort_order' => $question['sort_order'],
            ], [
                'form_no' => 2,
                'step' => $question['step'],
                'sort_order' => $question['sort_order'],
                'title' => $question['title'],
                'description' => $question['description'],
                'answer_type' => $question['answer_type'],
                'options' => $question['options'],
                'is_mandatory' => $question['is_mandatory'],
            ]);
        }

        $allQuestion = Question::where('form_no', 2)->get();
        return QuestionResource::collection($allQuestion);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
