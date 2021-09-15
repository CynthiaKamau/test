<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class MarvelController extends Controller
{

    public function index()
    {
        $pageTitle = 'Marvel Characters';

        return view('marvel', compact(['pageTitle']));
    }

    public function get_characters()
    {
        $ts = Carbon::now()->toDateString();          
        $private_key =  Config::get('services.marvel_private_key.key');
        $public_key = Config::get('services.marvel_public_key.key');
        $hash = md5($ts . $private_key . $public_key);

        $offset = 0;

        $results = [];

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://gateway.marvel.com:443/v1/public/characters?ts=".$ts."&apikey=".$public_key."&hash=".$hash,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "token" => $hash,
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {

            //getting all records

            $data = json_decode($response);

            $total = $data->data->total;

            if($total > 0) {

                //loop through other pages, increment offset by 20

                for ($offset; $offset < $total; $offset+=20) {

                    // looping based on offset

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://gateway.marvel.com:443/v1/public/characters?ts=".$ts."&apikey=".$public_key."&hash=".$hash."&limit=20&offset=".$offset,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "token" => $hash,
                    ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        return $err;
                    } else {

                        $data = json_decode($response);

                        return $data;

                        //add all results to array results

                        //array_push($results, $data->data->results);

                    }

                }    

                return $results;

            } else {

                return [];

            }

        }

    }

    public function get_characters_test(Request $request,$pgno)
    {
        if($pgno == null) {
            $pgno = 1;
        } 

        $ts = Carbon::now()->toDateString();          
        $private_key =  Config::get('services.marvel_private_key.key');
        $public_key = Config::get('services.marvel_public_key.key');
        $hash = md5($ts . $private_key . $public_key);

        //offset is looped through records, first page has nothing looped through
        $offset = ($pgno * 20) - 20;

        $results = [];

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://gateway.marvel.com:443/v1/public/characters?ts=".$ts."&apikey=".$public_key."&hash=".$hash."&limit=20&offset=".$offset."&orderBy=name",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "token" => $hash,
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {

            //getting all records

            $data = json_decode($response);

            $total = $data->data->total;

            return $data;

        }

    }

}
