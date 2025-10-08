<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    public function index()
    {
        return response()->json(Skill::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'level' => 'required|integer|min:0|max:100',
            'category' => 'required|string'
        ]);
        if($validator->fails())
        {
            return response() ->json([
                'status' => 422,
                'error' => $validator->messages()
            ],422);
        }else{
            $skills = Skill::create([
                'name' => $request->name,
                'level' => $request->level,
                'category' => $request->category,
            ]);
            if($skills){
                return response()->json([
                    'status' =>200,
                    'message'=>'Skill created Successfully'
                ],200);
            }else{
                return response()->json([
                    'status' =>500,
                    'message'=>'something went wrong'
                ],500);
             }
        }
    }

    public function show($id)
    {
        $skills =Skill::find($id);
        if($skills)
        {
            return response()->json([
                'status' =>200,
                'skills'=>$skills
            ],200);
        }
        else {
            return response()->json([
                'status' =>404,
                'message'=>'No Such skills'
            ],500);
        }
    }

    public function edit($id)
    {
        $skills =Skill::find($id);
        if($skills)
        {
            return response()->json([
                'status' =>200,
                'student'=>$skills
            ],200);
        }
        else {
            return response()->json([
                'status' =>404,
                'message'=>'No Such student'
            ],404);
        }
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|string',
            'level' => 'sometimes|integer|min:0|max:100',
            'category' => 'sometimes|string'
        ]);
        if($validator->fails())
        {
            return response() ->json([
                'status' => 422,
                'error' => $validator->messages()
            ],422);
        }else{
            $skills = Skill::find($id);

            if($skills){
                $skills->update([
                    'name' => $request->name,
                    'level' => $request->level,
                    'category' => $request->category,
                ]);

                return response()->json([
                    'status' =>200,
                    'skills' =>$skills
                ],200);

            }else{
                return response()->json([
                    'status' =>404,
                    'message'=>'No such skills Found'
                ],404);
            }
        }

    }

    public function destroy($id)
    {
        $skills = Skill::find($id);
        if($skills)
        {
            $skills->delete();
            return response()->json([
                'status' =>200,
                'message'=>'skills deleted successfully!'
            ],200);
        }
        else{
            return response()->json([
                'status' =>404,
                'message'=>'No Such skills Found!'
            ],404);
        }
    }
}
