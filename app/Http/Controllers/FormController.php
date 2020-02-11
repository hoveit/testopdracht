<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\Http\Requests\formulierRequest;

class FormController extends Controller
{
    public function store(formulierRequest $request) { 
        $formData = new Form();
        $formData->aanhef = $request->aanhef;
        $formData->voornaam = $request->voornaam;
        $formData->tussenvoegsel = $request->tussenvoegsel;
        $formData->achternaam = $request->tussenvoegsel;
        $formData->email = $request->email;
        $formData->land = $request->land;

        $formData->save();

        return response()->json([
            'message' => 'Successfully created form data!'
        ], 201);
    }

    public function index() { 
        return Form::all();
    }
}
