<?php
/**
 * Created by PhpStorm.
 * User: gwb13184
 * Date: 09/08/2016
 * Time: 14:37
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\FAQ;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class FAQsController extends Controller
{

    public function faqsPage()
    {
        $questions = DB::table('faqs')->get();
        if ( Auth::check() && Auth::User()->type == 'admin') {
            return view('FAQs', ['questions' => $questions, 'edit' => true]);
        }
        return view('FAQs', ['questions' => $questions]);
    }

    public function edit($question_id = null)
    {

        $user = Auth::User();
        if (Auth::check() && $user->type == 'admin') {

            if(isset($question_id)){
                return view('admin.editFAQ', ['pair' => FAQ::find($question_id),'manFields'=>['question']]);
            }
            else{
                return view('admin.editFAQ',['manFields'=>['question']]);
            }
        }
        return abort(404);
    }

    public function submit(Request $request)
    {

        $user = Auth::User();
        if (Auth::check() &&  !$user->type == 'admin') {
            return redirect('/');
        }
        if ($request->has('question_id')) {
            $data = FAQ::find($request->input('question_id'));
        } else {
            $data = new FAQ();
        }

        if ($request->has('question')) {
            $data->question = trim($request->input('question'));
        }

        if ($data->question == null) {
            Flash::Message('FAQ must contain a question', 'danger')->important();
            return back();
        }

        if($request->has('answer')){
            $data->answer = trim($request->input('answer'));
        }
        else{
            $data->answer = null;
        }
        $data->save();

        if ($request->has('question_id')) {
            Flash::Message('Question updated', 'success')->important();
        } else {
            Flash::Message('Question created', 'success')->important();
        }


        return redirect('/FAQs');


    }

    public function delete($question_id)
    {
        FAQ::find($question_id)->delete();
        Flash::Message('Question deleted', 'success')->important();

        return redirect('/FAQs');
    }
}