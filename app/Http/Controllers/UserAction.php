<?php

namespace App\Http\Controllers;
use App\Models\SkillRequest;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use function PHPUnit\Framework\returnArgument;

class UserAction extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            $user = $request->user();
            $skillsHave = $user->skills()->where('type', 'have')->get();
            $skillsWant = $user->skills()->where('type', 'want')->get();

            $alreadySentTo = SkillRequest::where('sender_id', $user->id)->pluck('receiver_id')->all();
            $alreadyRecievedFrom = SkillRequest::where('receiver_id', $user->id)->pluck('sender_id')->all();
            $alreadySentTo = array_merge($alreadySentTo, $alreadyRecievedFrom);
            $eligibleMatches = User::where('id', '!=', $user->id)
        ->whereNotIn('id', $alreadySentTo)
        ->whereHas('skills', function(Builder $query) use ($skillsWant) {
            $query->whereIn('skill_name', $skillsWant->pluck('skill_name'))->where('type', 'have');
        })->whereHas('skills', function(Builder $query) use ($skillsHave) {
            $query->whereIn('skill_name', $skillsHave->pluck('skill_name'))->where('type', 'want');
        })->get();

            $sentRequests = SkillRequest::with('receiver')->where('sender_id', $user->id)->get();

            $recievedRequests = SkillRequest::with('sender')->where('receiver_id', $user->id)->where('status', 'pending')->get();

            $matchedUsers = SkillRequest::with((['sender','receiver']))->where('status', 'accepted')->where(function($q) use ($user){
            $q->where('receiver_id', $user->id);
            $q->orWhere('sender_id', $user->id);
            })->get();
            
            return view("dashboard",compact("user","skillsHave", "skillsWant", "eligibleMatches", "recievedRequests", "sentRequests", "matchedUsers"));
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

    // Skill Request Functionality
    public function sendRequest(Request $request, $userId){
        $user = $request->user();
        $matchedUserId = $request->input('matched_user_id');
        if($userId && $matchedUserId && $userId != $matchedUserId && $request->isMethod('POST')){
            if(SkillRequest::where('sender_id', $userId)->where('receiver_id', $matchedUserId)->exists()){
                return redirect()->back()->with('error','Request already sent to this user');
            }
            $skillRequest = SkillRequest::create([
                'sender_id'=> $user->id,
                'receiver_id'=> $matchedUserId,
                'status' => 'pending',
            ]);
            $skillRequest->save();
            return redirect()->back()->with('success','Request sent successfully');
        }else{
            return redirect()->back()->with('error','Unable to send request');
        }
    }


    public function destroySkillRequest(Request $request, $request_id){
        $skillRequest = SkillRequest::where('id', $request_id)->first();
        if($skillRequest){
            $skillRequest->delete();
            return redirect()->back()->with('success', 'Skill request deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Skill request not found');
        }
    }
    
    public function getSentRequests(Request $request){
        $user = $request->user();
        $sentRequests = SkillRequest::with('receiver')->where('sender_id', $user->id)->get();
        return view('sent_requests', compact('sentRequests'));
    }


    public function getRecievedRequest(Request $request){
        $user = $request->user();
        $recievedRequests = SkillRequest::with('sender')->where('receiver_id', $user->id)->get();
        return view('recieved_request', compact('recievedRequests'));
    }

    public function updateSkillRequest(Request $request, $skillId){
        $user = $request->user();
        $skillRequest = SkillRequest::where('id', $skillId)->first();
        if($skillRequest && $skillRequest->receiver_id == $user->id){
            if($request->input('action') == 'accept'){
                $skillRequest->status = 'accepted';
                $skillRequest->save();
            } elseif($request->input('action') == 'reject'){
                $skillRequest->status = 'rejected';
                $skillRequest->save();
            }
            return redirect()->back()->with('success-update', 'Skill request updated successfully');
        } else {
            return redirect()->back()->with('error-update', 'Skill request not found');
        }
    }

    public function viewAccepted(Request $request){
        $user = $request->user();
        $acceptedRequests = SkillRequest::with((['sender','receiver']))->where('status', 'accepted')->where(function($q)
        use ($user){
            $q->where('receiver_id', $user->id);
            $q->orWhere('sender_id', $user->id);
        })->get();
        return view('view_accepted', compact('acceptedRequests', 'user'));
    }

}
