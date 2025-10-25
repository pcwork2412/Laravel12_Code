<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ Validation
            $data = $request->validate([
                'newsletter_email' => 'required|email|unique:newsletters,newsletter_email'
            ], [
                'newsletter_email.unique' => 'This email is already subscribed to our newsletter.',
                'newsletter_email.required' => 'Please enter your email address.',
                'newsletter_email.email' => 'Please enter a valid email address.'
            ]);


            // ✅ Save newsletter
            $newsletter = Newsletter::create($data);

            // ✅ Ajax request
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Newsletter Created Successfully',
                    'newsletter' => $newsletter
                ]);
            }
            // ✅ Normal request
            else {
                return redirect()->route('web.index')->with('success_email', 'Email Sent successfully! We will contact you soon.');

            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Validation errors
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please fix the following errors:',
                    'errors'  => $e->errors(),
                ], 422);
            } else {
                // Laravel खुद ही back redirect करके errors flash कर देता है
                throw $e;
            }
        } catch (\Exception $e) {
            // ✅ Unexpected errors
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unexpected error occurred. Please contact support.',
                    'debug' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            } else {
                return redirect()->back()->with('error', 'Unexpected error occurred. Please try again later.');
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        //
    }
}
