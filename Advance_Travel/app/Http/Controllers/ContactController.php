<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ContactMessage;


class ContactController extends Controller
{
public function store(Request $request)
{
$validated = $request->validate([
'name' => ['required','string','max:120'],
'email' => ['required','email','max:150'],
'message' => ['required','string','max:2000'],
]);


ContactMessage::create($validated);


// Later: dispatch mail job or notification
return back()->with('success', 'Thanks for contacting us!');
}
}