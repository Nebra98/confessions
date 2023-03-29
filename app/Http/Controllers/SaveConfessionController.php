<?php

namespace App\Http\Controllers;

use App\Models\SaveConfession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveConfessionController extends Controller
{
    public function saveConfession(Request $request)
    {
        $confession_id = $request->input('confession_id');
        $user_id = Auth::id();

        $savedConfession = SaveConfession::where('confession_id', $confession_id)->where('user_id', $user_id)->first();

        if($savedConfession)
        {
            $savedConfession->delete();
            $savedConfessionCount = Auth::user()->saveConfessions()->count();

            return response()->json([
                'success' => true,
                'action' => 'unsaved',
                'savedConfessionCount' => $savedConfessionCount
            ]);
        }

        $savedConfession = new SaveConfession();
        $savedConfession->user_id = $user_id;
        $savedConfession->confession_id = $confession_id;
        $savedConfession->save();

        $savedConfessionCount = Auth::user()->saveConfessions()->count();

        return response()->json([
            'success' => true,
            'action' => 'saved',
            'savedConfessionCount' => $savedConfessionCount
        ]);
    }
}
