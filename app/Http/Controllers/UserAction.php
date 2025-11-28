<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserAction extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            $user = $request->user();
            $skillsHave = $user->skills()->where('type', 'have')->get();
            $skillsWant = $user->skills()->where('type', 'want')->get();
            $matchedUsers = User::where('id', '!=', $user->id)
        ->whereHas('skills', function(Builder $query) use ($skillsWant) {
            $query->whereIn('skill_name', $skillsWant->pluck('skill_name'))->where('type', 'have');
        })->whereHas('skills', function(Builder $query) use ($skillsHave) {
            $query->whereIn('skill_name', $skillsHave->pluck('skill_name'))->where('type', 'want');
        })->get();
            return view("dashboard",compact("user","skillsHave", "skillsWant", "matchedUsers"));
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
