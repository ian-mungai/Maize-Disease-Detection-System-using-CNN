<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PredictionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $predictions = Prediction::all();

        return view('predictions.index', compact('predictions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('predictions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        $imagePath = public_path('images')."/".$imageName;

        $client = new Client();
        $img = fopen($imagePath, 'r');
        $resp = $client->request('POST', env('FLASK_IP').':'. env('FLASK_PORT').'/disease-analyzer' , ['json'=> ['img' => $imagePath]]);

        $prediction = new Prediction();
        $prediction->description = $request->description;
        $prediction->imageName = $imageName;
        $prediction->userId = 1;
        $prediction->prediction =  $resp->getBody();

        $prediction->save();
        return redirect()->route('predictions.index')
        ->with('Success', 'Prediction successfull.');

    }

    public function show(Prediction $prediction)
    {
        return view('predictions.show', compact('prediction'));
    }

    public function edit(Prediction $prediction)
    {
        //
    }

    public function update(Request $request, Prediction $prediction)
    {
        //
    }

    public function destroy(Prediction $prediction)
    {
        //
    }
}
