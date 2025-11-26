<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserAction extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            $user = $request->user();
            return view("dashboard",compact("user"));
        }
        else{
            return view("dashboard");
        }
    }

    public function addSkill(Request $request){
        $user = $request->user();
        $skillName = $request->input('skill_name');
        $type = $request->input('type'); // have or want

        $created = $user->skills()->create([
            'skill_name' => $skillName,
            'type' => $type,
        ]);
        if($created){
            return redirect()->back()->with('success','You have added your skill');
        }else{
            return redirect()->back()->with('error',"Unable to add your skill, it's not you it's me");
        }
    }
    public function deleteSkill(Request $request){
        $user = $request->user();
        $skillId = $request->input('skill_id');

        $skill = $user->skills()->where('id',$skillId)->first();
        if($skill){
            $skill->delete();
            return redirect()->back()->with('success','Skill deleted successfully');
        }else{
            return redirect()->back()->with('error','Skill not found');
        }
    }
}
