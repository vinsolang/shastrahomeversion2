<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function redirectToTelegram(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'phone_number' => 'required',
        'email_address' => 'required|email',
        'project_type' => 'required',
        'message' => 'nullable|string',
    ]);

    $message = "📩 New Contact Inquiry\n\n"
        . "Full Name: {$request->first_name}\n"
        . "Phone: {$request->phone_number}\n"
        . "Email: {$request->email_address}\n"
        . "Project: {$request->project_type}\n"
        . "💬 Message: " . ($request->message ?: '-');

    $url = "https://t.me/Shastrahome?text=" . urlencode($message);

    return response()->json([
    'url' => $url
]);
}
}
