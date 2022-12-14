<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * get Questions 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $questions = Question::where('is_active', 1)->get();
        return view('admin.questions.index', ['questions' => $questions]);
    }
    /**
     * create new question page
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        return view('admin.questions.create');
    }
    /**
     * store question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        get_locale();
        $data = $request->validate([
            'question_ar' => 'required',
            'question_en' => 'required',
            'answer_ar' => 'required',
            'answer_en' => 'required'
        ]);
        $question = Question::create($data);
        if ($question) {
            return back()->with(['success' => __('messages.create_success')]);
        }
    }
    /**
     * update question page
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        get_locale();
        $question = Question::find($id);
        if ($question == null) return abort(404);
        return view('admin.questions.update', ['question' => $question]);
    }
    /**
     * update question 
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        get_locale();
        $question = Question::find($id);
        if ($question == null) return abort(404);
        $data = $request->validate([
            'question_ar' => 'required',
            'question_en' => 'required',
            'answer_ar' => 'required',
            'answer_en' => 'required',
            'is_active' => 'nullable'
        ]);
        $question->update($data);
        return back()->with(['success' => __('messages.update_success')]);
    }
    /**
     * delete question
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $question = Question::find($id);
        $question->delete();
        return back()->with(['success'=>__('messages.delete_success')]);
    }
}
