<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PortofolioController extends Controller
{
    public function index()
    {
        $birthday = "1997-01-27";
        $biday = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($biday);
        return view('welcome', compact('diff', 'birthday'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
           'pengirim' => 'required',
           'email' => 'required',
           'pesan' => 'required'
        ]);

        $pengirim = $request->pengirim;
        $email = $request->email;
        $pesan = $request->pesan;
        $data = [
            'pengirim' => $pengirim,
            'email' => $email,
            'pesan' => $pesan
        ];

        try {
            Mail::send('email', $data, function ($message) use ($request) {
                $message->from($request->email, $request->pengirim);
                $message->subject('Pertanyaan dari ' . $request->pengirim);
                $message->to('faisal.ilhami2797@gmail.com', 'Muhamad Faisal Ilhami Akbar');
            });
            return response()->json(['msg' => 'Pesan anda sudah terkirim']);
        } catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
}
