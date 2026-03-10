<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;

class WelcomeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::actif()->get();

        return view('welcome', compact('documentTypes'));
    }
}