<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AFCInfoController extends Controller
{
    public function register(Request $request)
    {
        $user = DB::table('user_details')->where('email', $request['email']);
        if($user->exists()) {
            return response()->json('Email Already Exist');
        } else {
            if($request['email'] == '') {
                return response()->json('Email Is Empty', 200);
            } else if($request['fullname'] == '') {
                return response()->json('Fullname Is Empty', 200);
            } else if($request['username'] == '') {
                return response()->json('Username Is Empty', 200);
            } else if($request['password'] == '') {
                return response()->json('Password Is Empty', 200);
            } else if($request['country'] == '') {
                return response()->json('Country Is Empty', 200);
            } else {
                DB::table('user_details')->insert([
                    'email' => $request['email'],
                    'fullname' => $request['fullname'],
                    'username' => $request['username'],
                    'password' => password_hash($request['password'], PASSWORD_DEFAULT),
                    'country' => $request['country'],
                ]);

                $res = [
                    "id"=>$user->first()->id,
                ];

                return response()->json($res, 200);
            }
        }
    }

    public function login(Request $request)
    {
        if(isset($request['email'])) {
            $user=DB::table('user_details')->where('email', $request['email']);
            if ($user->exists()){
                $pass=$user->first()->password;
                if(password_verify($request['password'], $pass)){
                    $res=[
                        'id'=>$user->first()->id,
                        'email'=>$user->first()->email,
                        'username'=>$user->first()->username,
                        'fullname'=>$user->first()->fullname,
                        'country'=>$user->first()->country,
                    ];
                    return response()->json($res, 200);
                } else {
                    return response()->json('Wrong Password. Please Try Again');
                }
            } else {
                return response()->json('Email Do Not Exist');
            }
        }
    }

    public function countries(Request $request)
    {
        $country = DB::table('countries')->where('country_name', $request['country_name']);
        if($country->exists()) {
            return response()->json('Country Already Register');
        } else {
            if($request['country_name'] == '') {
                return response()->json('No Country Name', 200);
            } else if($request['country_flag'] == '') {
                return response()->json('No Country Flag', 200);
            } else if($request['region'] == '') {
                return response()->json('No Region', 200);
            } else if($request['ranking'] == '') {
                return response()->json('No Ranking', 200);
            } else {
                DB::table('countries')->insert([
                    'country_name' => $request['country_name'],
                    'country_flag' => $request['country_flag'],
                    'region' => $request['region'],
                    'ranking' => $request['ranking'],
                ]);

                return response()->json('Country Registered into AFC', 200);
            }
        }
    }

    public function getCountries(Request $request)
    {
        $countries = DB::table("countries")->select('country_name', 'country_flag', 'ranking')->get();

        return response()->json($countries);
    }

    public function registerPlayers(Request $request)
    {
        $country = DB::table('squads')->where('player_name', $request['player_name']);
        if($country->exists()) {
            return response()->json('Player Already Register');
        } else {
            if($request['player_name'] == '') {
                return response()->json('No Player Name', 200);
            } else if($request['jersey_number'] == '') {
                return response()->json('No Player Jersey', 200);
            } else if($request['position'] == '') {
                return response()->json('No Position', 200);
            } else if($request['country_name'] == '') {
                return response()->json('No Country Name', 200);
            } else if($request['country_flag'] == '') {
                return response()->json('No Country Flag', 200);
            } else {
                DB::table('squads')->insert([
                    'player_name' => $request['player_name'],
                    'jersey_number' => $request['jersey_number'],
                    'position' => $request['position'],
                    'country_name' => $request['country_name'],
                    'country_flag' => $request['country_flag'],
                ]);

                return response()->json('Player Registered into AFC', 200);
            }
        }
    }

    public function getSquads(Request $request)
    {
        $request->validate([
            'country_name'=>'required|string',
        ]);

        $countryName = $request->input('country_name');
        $squads = DB::table('squads')->where('country_name', $countryName)->orderBy('jersey_number')->get();

        return response()->json(['squads'=>$squads], 200);
    }
}
