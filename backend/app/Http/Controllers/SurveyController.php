<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $survey = Survey::all();
        return response()->json($survey,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save1(Request $request,$id)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);
        return response()->json($survey);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
