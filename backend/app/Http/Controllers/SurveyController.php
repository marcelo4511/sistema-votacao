<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{

    public function index(Request $request)
    {
        $pesquisa = $request->get('pesquisa');
         $survey = Survey::when($request['pesquisa'],function($query) use($pesquisa) {
             $query->where('title','LIKE',"$pesquisa%")
             ->orWhere(DB::raw("(DATE_FORMAT(dateinicial,'%d/%m/%Y'))"),'LIKE',"$pesquisa%")
             ->orWhere(DB::raw("(DATE_FORMAT(datefinal,'%d/%m/%Y'))"),'LIKE',"$pesquisa%")
             ->where('status','LIKE',"$pesquisa%");
         })->orderBy($request->column, $request->order)->paginate(intval($request->per_page));
         return response()->json($survey,200);
    }

    function save1(Request $request,$id)
    {
        $count = Survey::find($id);

        $count->totaloption1 += 1;

        $count->save();

        return ($count);
    }

    public function save2(Request $request,$id)
    {
        $count = Survey::find($id);

        $count->totaloption2 += 1;

        $count->save();

        return ($count);
    }

    public function save3(Request $request,$id)
    {
        $count = Survey::find($id);

        $count->totaloption3 += 1;

        $count->save();

        return ($count);
    }

    public function store(Request $request)
    {
        $survey = new Survey();
        $survey->title = $request->input('title');
        $survey->dateinicial = $request->input('dateinicial');
        $survey->datefinal = $request->input('datefinal');
        $survey->option1 = $request->input('option1');
        $survey->option2 = $request->input('option2');
        $survey->option3 = $request->input('option3');
        //$survey->status = $request->input('status');
        $survey->save();
        return response()->json($survey);
    }

    public function show($id)
    {
        $survey = Survey::find($id);
        return response()->json($survey);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $survey = Survey::findOrFail($id);
            $survey->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Enquete Atualizada com sucesso'
                ]   
                ],200);
        }catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }
    }

    public function destroy($id)
    {
        try{

			$survey = Survey::findOrFail($id);
			$survey->delete();

			return response()->json([
				'data' => [
					'msg' => 'Enquete removida com sucesso!'
				]
			], 200);

		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()],401);
		}
    }
}
