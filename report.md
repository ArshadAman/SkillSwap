# SkillSwap: A Peer-to-Peer Skill Exchange Platform
 
## Table of Contents
1. Introduction  
2. Objectives  
3. Module-wise Functionality  
4. System Design  
   - Database Table Structure  
   - ER Diagram  
   - Use Cases  
5. Implementation  
   - Technology Stack  
   - Sample Code  
6. Screenshots  
7. Conclusion and Future Improvements  
8. References  

---

## 1. Introduction
SkillSwap is a web application that enables users to exchange skills without monetary transactions. Users register, list skills they can teach (“have”) and skills they want to learn (“want”), search for complementary peers, and send skill swap requests. The request lifecycle supports sending, accepting, rejecting, and canceling. Once a request is accepted, both users can view each other’s contact info to coordinate sessions.

The MVP focuses on:
- Secure authentication and session handling.
- Skills management with clearly typed skills.
- Matching logic that finds complementary users while excluding those you already requested.
- Request lifecycle management with status tracking and access control.
- A dashboard summarizing sent/received/accepted requests and matched user suggestions.

---

## 2. Objectives
- Provide a frictionless onboarding flow for users to create accounts.
- Enable users to list “have” and “want” skills and manage them easily.
- Implement matching to identify peers where each has what the other wants.
- Support sending, accepting, rejecting, and canceling skill swap requests.
- Only reveal contact info after acceptance for privacy.
- Maintain a clean and responsive UI using Tailwind CSS.
- Ensure a secure backend: CSRF protection, mass-assignment guardrails, and relationship integrity via foreign keys.

---

## 3. Module-wise Functionality
- Authentication
  - Register, login, logout; CSRF-protected forms; session-based auth.
- Profile
  - View name, email, optional contact info; basic edit flow (future enhancement).
- Skills Management
  - Add/delete skills with type = have/want; chip-style visual listing.
- Matching
  - Compute eligible matches excluding users already requested; show complementary skills.
- Requests
  - Send request to matched peers; track sent and received; accept/reject; cancel pending.
  - On acceptance, show both users’ contact info and shortcut to email.
- Dashboard
  - Summary cards: “Requests I Sent”, “Requests I Received”, “Matched Users” (accepted), and match suggestions.
- Middleware/Access
  - Auth middleware protects dashboard and all request/skill actions.

---

## 4. System Design

### 4.1 Database Table Structure
- users
  - id (PK), name, email (unique), password, contact_info (nullable), timestamps
  - Migrations: create_users_table + add_contact_info_to_users_table
- skills
  - id (PK), user_id (FK → users.id cascade), skill_name, type ENUM('have','want'), timestamps
- skill_requests
  - id (PK), sender_id (FK → users.id cascade), receiver_id (FK → users.id cascade), status ENUM('pending','accepted','rejected'), timestamps
  - Note: offered_skill/requested_skill columns removed in later migration

### 4.2 ER Diagram (textual)
- User (1) — (M) Skill  
- User (1) — (M) SkillRequest as sender (sender_id)  
- User (1) — (M) SkillRequest as receiver (receiver_id)  
- SkillRequest links two Users: sender_id and receiver_id; status controls lifecycle

### 4.3 Use Cases
- UC-1 Register/Login: User creates account and authenticates.
- UC-2 Manage Skills: User adds/deletes have/want skills.
- UC-3 Find Matches: System suggests users who have what you want and want what you have; excludes users already requested.
- UC-4 Send Request: User sends a swap request to matched peer.
- UC-5 Accept/Reject: Receiver accepts or rejects; upon acceptance, both see contact info.
- UC-6 Cancel Sent: Sender can cancel pending requests.
- UC-7 View Accepted: Either party can view accepted pairs and contact details.

---

## 5. Implementation

### 5.1 Technology Stack
- Backend: Laravel (PHP 8.2)
- Frontend: Blade templates, Tailwind CSS (browser CDN), jQuery (asset)
- Database: SQLite/MySQL/PostgreSQL (via config)
- Tooling: Artisan, PHPUnit, Eloquent ORM

### 5.2 Sample Code

- Routes
```php
// filepath: /Users/arshadaman/skillswap/skillswap/routes/web.php
// ...existing code...
Route::middleware('auth')->group(function () {
    Route::get('/', [UserAction::class,'index'])->name('dashboard');

    // Skills
    Route::post('/add-skill', [UserAction::class, 'addSkill'])->name('add-skill');
    Route::post('/delete-skill', [UserAction::class, 'deleteSkill'])->name('delete-skill');

    // Requests
    Route::post('/send-request/{userId}', [UserAction::class, 'sendRequest'])->name('send-request');
    Route::get('/view-sent-request', [UserAction::class, 'getSentRequests'])->name('view_sent_request');
    Route::get('/view-recieved-request', [UserAction::class,'getRecievedRequest'])->name('view_recieved_request');
    Route::post('/delete-skill-request/{request_id}', [UserAction::class, 'destroySkillRequest'])->name('delete_skill_request');
    Route::post('/update-status/{skillId}',[UserAction::class,'updateSkillRequest'])->name('update_skill_request');
    Route::get('/view-accepted', [UserAction::class,'viewAccepted'])->name('view_accepted');
});
// ...existing code...
```

- Models and Relationships
```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Models/User.php
// ...existing code...
public function sentRequests(){
    return $this->hasMany(SkillRequest::class, 'sender_id');
}
public function receivedRequests() {
    return $this->hasMany(SkillRequest::class, 'receiver_id');
}
public function skills(){
    return $this->hasMany(Skill::class, 'user_id');
}
public function haveSkills(){ return $this->skills()->where('type','have'); }
public function wantSkills(){ return $this->skills()->where('type','want'); }
```

```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Models/Skill.php
class Skill extends Model
{
    protected $fillable = ['user_id','skill_name','type'];
    public function user(){ return $this->belongsTo(User::class); }
}
```

```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Models/SkillRequest.php
class SkillRequest extends Model
{
    protected $fillable = ['sender_id','receiver_id','status'];
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
    public function receiver() { return $this->belongsTo(User::class, 'receiver_id'); }
}
```

- Controller Logic (matching, requests)
```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Http/Controllers/UserAction.php
// Filtering matched users to exclude users already requested
$alreadySentTo = SkillRequest::where('sender_id', $user->id)->pluck('receiver_id')->all();

$matchedUsers = User::with('skills')
    ->where('id', '!=', $user->id)
    ->whereNotIn('id', $alreadySentTo)
    ->whereHas('skills', function(Builder $q) use ($skillsWant){
        $q->whereIn('skill_name', $skillsWant->pluck('skill_name'))
          ->where('type','have');
    })
    ->whereHas('skills', function(Builder $q) use ($skillsHave){
        $q->whereIn('skill_name', $skillsHave->pluck('skill_name'))
          ->where('type','want');
    })
    ->get();
```

```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Http/Controllers/UserAction.php
public function sendRequest(Request $request, $userId){
    $user = $request->user();
    $request->validate(['matched_user_id' => 'required|exists:users,id|different:'.$user->id]);

    if (SkillRequest::where('sender_id', $user->id)->where('receiver_id', $request->matched_user_id)->exists()) {
        return back()->with('error','Request already sent to this user.');
    }

    SkillRequest::create([
        'sender_id'=> $user->id,
        'receiver_id'=> (int) $request->matched_user_id,
        'status' => 'pending',
    ]);

    return back()->with('success','Request sent successfully.');
}
```

```php
// filepath: /Users/arshadaman/skillswap/skillswap/app/Http/Controllers/UserAction.php
public function updateSkillRequest(Request $request, $skillId){
    $user = $request->user();
    $skillRequest = SkillRequest::find($skillId);

    if(!$skillRequest || $skillRequest->receiver_id !== $user->id){
        return back()->with('error-update','Skill request not found or unauthorized.');
    }

    $action = $request->input('action');
    if($action === 'accept'){ $skillRequest->status = 'accepted'; }
    elseif($action === 'reject'){ $skillRequest->status = 'rejected'; }

    $skillRequest->save();
    return back()->with('success-update','Skill request updated successfully.');
}
```

- Flash Message Snippet (for Dashboard boxes)
```blade
@if(session('success'))
  <div class="rounded-md bg-emerald-50 text-emerald-700 px-4 py-3">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="rounded-md bg-rose-50 text-rose-700 px-4 py-3">{{ session('error') }}</div>
@endif
@if($errors->any())
  <div class="rounded-md bg-amber-50 text-amber-800 px-4 py-3">
    <ul class="list-disc list-inside text-sm">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif
```

---

## 6. Screenshots
Include full-page screenshots captured from your running app:
1. Dashboard main: profile, skills, sent/received, matched users.
2. Received requests list with Accept/Reject.
3. Sent requests list with status chips and Cancel.
4. Accepted requests list showing partner contact info.
5. Register page with validation.
6. Login page with CSRF-protected form.

Tip (Mac): Shift+Cmd+4 to capture selections.

---

## 7. Conclusion and Future Improvements
SkillSwap delivers a practical MVP for peer-to-peer skill exchanges. The system supports onboarding, skill management, complementary matching, and a robust request lifecycle with secure access. It’s modular, using clean Eloquent relationships, and optimized via eager-loading where needed.

Future improvements:
- Advanced matching (weights, categories, location/proximity)
- In-app messaging and scheduling (calendar integration)
- Email/in-app notifications
- Profile editing, avatars, and bios
- Rate limiting and spam prevention
- Pagination, caching, and query indexing for scalability
- Admin dashboard and moderation features

---

## 8. References
- Laravel Documentation: https://laravel.com/docs  
- Tailwind CSS: https://tailwindcss.com  
- jQuery: https://jquery.com  
- Eloquent ORM: https://laravel.com/docs/eloquent  
- Blade Templates: https://laravel.com/docs/blade