<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class buildPC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dnd:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'build a character';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function playerRace($client){
        $response = $client->request('GET', 'races/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        $pRace =[];

        foreach ($body['results'] as $item){
            $pRace[] = $item['name'];
        }

        $playerRace = $this->choice(
            'Pick your Base Race',
            $pRace
        );

        foreach ($body['results'] as $item){
            if($playerRace === $item['name']){
                return [
                    'name'=>$playerRace,
                    'url'=>$item['url']
                ];
            }
        }
    }
    protected function getUrlId($url){
        $url =parse_url ($url,PHP_URL_PATH);
        $splitUrl = explode('/',$url);
        return $splitUrl[3];
    }
    protected function playerSubRace($client,$url){

        $id = $this->getUrlId($url);
        $response = $client->request('GET', 'races/'.$id);
        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);
return $body;
    }

    protected function playerClass($client){
        $response = $client->request('GET', 'classes/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        $pClass =[];
        foreach ($body['results'] as $item){
            $pClass[] = $item['name'];
        }

        $playerClass = $this->choice(
            'Pick your Class',
            $pClass
        );

        foreach ($body['results'] as $item){
            if($playerClass === $item['name']){
                return [
                    'name'=>$playerClass,
                    'url'=>$item['url']
                ];
            }
        }


        return $playerClass;
    }

    protected function playerClassBuild($client,$url){

        $id = $this->getUrlId($url);
        $response = $client->request('GET', 'classes/'.$id);
        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);


        foreach ($body['proficiency_choices'] as $proficiency){
            // build list then ask

            $proficiency = collect($proficiency);
            $choices = $proficiency['choose'];
            $flattened = $proficiency['from']->map(function ($item,$key) {
                                dd($item,$key);
                return nulll;
            });

            foreach ($proficiency['from']
            )
//
//            $choiceList = $proficiency->map(function ($item, $key) {
//                dd($item,$key);
//
//                return $item * 2;
//            });


        }

        // build proficiency_choices
        // in proficiencies





        return $body;
    }


    protected function stats($client){

        $response = $client->request('GET', 'ability-scores/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        $stats = [];
        // build basics name and stats
        foreach($body['results'] as $item){

            $input = $this->ask('What is your: '.$item['name']);
            $stats[] = [
                'name'=>$item['name'],
                'value'=>$input,
                'url'=>$item['url']
            ];
        }
    return $stats;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    //

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://dnd5eapi.co/api/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

//        $playerStats = $this->stats($client);

        $playerClass = $this->playerClass($client);

        $playerClass2 = $this->playerClassBuild($client,$playerClass['url']);

        dd($playerClass2);
//        $playerRace = $this->playerRace($client);
//        $this->playerSubRace($client,$playerRace['url']);


        // Build your Race
 return null;

    }
}
