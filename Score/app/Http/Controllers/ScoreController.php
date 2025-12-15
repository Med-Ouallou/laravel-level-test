<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = Score::orderBy('points', 'desc')->get(); 
        return view('scores.index', compact('scores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:255',
            'points'      => 'required|integer|min:0',
        ]);

        Score::create($request->all());

        return redirect()->route('scores.index')->with('success', 'Score ajouté !');
    }

    public function destroy(Score $score)
    {
        $score->delete();

        return redirect()->route('scores.index')->with('success', 'Score supprimé !');
    }
}