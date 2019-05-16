<?php

namespace App\Http\Controllers;

use App\Api\Transformers\LessonTransformer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends ApiController
{

    /**
     * @var LessonTransformer
     */
    protected $lessonTransformer;

    public function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;

        $this->middleware('auth.basic')->only('store');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lessons = Lesson::all();
        return $this->respond([
                'data' => $this->lessonTransformer->transformCollection($lessons)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:title|max:255',
            'body'  => 'required',
        ]);
        $error = [];
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field => $message):
                $error[$field] = $validator->errors()->first($field);
            endforeach;
            return $this->setStatusCode(422)->respondWithError('Parameters ' . implode(', ', array_keys($error)) . ' failed validation for a lesson');
        }

        Lesson::query()
            ->create([
                'title' => $request->input('title'),
                'body'  => $request->input('body')
            ]);

        return $this->setStatusCode(201)->respond([
            'message' => 'Lesson sucessfully create'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param $lessonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($lessonId)
    {
        $lesson = Lesson::query()->find($lessonId);
        if (!$lesson) {
            return $this->respondNotFound('Lesson Not Found');
        }
        return $this->respond([
            'data' => $this->lessonTransformer->transform($lesson->toArray()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        // Store the blog post...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }


}
