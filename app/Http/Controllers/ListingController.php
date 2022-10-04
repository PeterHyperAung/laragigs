<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    static function checkCurrentUser($id){
        if($id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
    }

    // show all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6)
        ]);
    }

    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    
    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing){
        static::checkCurrentUser($listing->user_id);
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing){
        static::checkCurrentUser($listing->user_id);
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }

         $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing){
        static::checkCurrentUser($listing->user_id);
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    // Manage Listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings]);
    }
 
}
