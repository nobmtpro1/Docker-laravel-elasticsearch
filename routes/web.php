<?php

use App\Models\Article;
use App\Models\User;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Route;
use Elasticsearch\Exception\ClientResponseException;
use Elasticsearch\Exception\ServerResponseException;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $client = ClientBuilder::create()
        ->setHosts(['elasticsearch'])
        ->setBasicAuthentication('elastic', '123')
        ->build();

    // index all user
    // $params = ['index' => 'users'];
    // $client->indices()->delete($params);
    // $users = User::all();
    // $params = [];
    // foreach ($users as $user) {
    //     $params['body'][] = [
    //         'index' => [
    //             '_index' => 'users',
    //         ]
    //     ];

    //     $params['body'][] = $user->toArray();
    // }
    // $response = $client->bulk($params);

    $params = [
        'index' => 'users',
        'body'  => [
            'query' => [
                'bool' => [
                    'must' => [
                        // "match" => [
                        //     "email" => "example.com"
                        // ],
                        [
                            "wildcard" => [
                                "email" => "*.c*"
                            ]
                        ]
                    ],
                ]
            ],
            "size" => 100
        ]
    ];
    $response = $client->search($params);

    dd($response);
    // return $client->indices()->exists((["index" => "p1roduct"]));

    // return view('welcome');
});
