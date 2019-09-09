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

    protected function playerRace($client)
    {
        $response = $client->request('GET', 'races/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);

        $pRace = [];

        foreach ($body['results'] as $item) {
            $pRace[] = $item['name'];
        }

        $playerRace = $this->choice(
            'Pick your Base Race',
            $pRace
        );

        foreach ($body['results'] as $item) {
            if ($playerRace === $item['name']) {
                return [
                    'name' => $playerRace,
                    'url' => $item['url']
                ];
            }
        }
    }

    protected function removeFromList($list, $item)
    {
        $newList = [];

        foreach ($list as $value) {
            if ($value != $item) {
                $newList[] = $value;
            }
        }
        return $newList;
    }

    protected function getUrlId($url)
    {
        $url = parse_url($url, PHP_URL_PATH);
        $splitUrl = explode('/', $url);
        return $splitUrl[3];
    }

    protected function playerSubRace($client, $url)
    {

        $id = $this->getUrlId($url);
        $response = $client->request('GET', 'races/' . $id);
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);
        return $body;
    }

    protected function playerClass($client)
    {
        $response = $client->request('GET', 'classes/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);

        $pClass = [];
        foreach ($body['results'] as $item) {
            $pClass[] = $item['name'];
        }

        $playerClass = $this->choice(
            'Pick your Class',
            $pClass
        );

        foreach ($body['results'] as $item) {
            if ($playerClass === $item['name']) {
                return [
                    'name' => $playerClass,
                    'url' => $item['url']
                ];
            }
        }


        return $playerClass;
    }

    protected function playerClassBuild($client, $url)
    {

        $id = $this->getUrlId($url);
        $response = $client->request('GET', 'classes/' . $id);
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);


        $playerClassBuild = collect([
            "name" => $body['name'],
            "hit_die" => $body['hit_die'],
            "proficiencies" => $body['proficiencies'],
            "saving_throws" => $body['saving_throws'],
            "starting_equipment" => $body['starting_equipment'],
            "class_levels" => $body['class_levels'],
            "subclasses" => $body['subclasses'],
            "url" => $body['url'],
        ]);

        $buildChoices = [];
        foreach ($body['proficiency_choices'] as $proficiency) {
            // build list then ask
            $listChoices = $proficiency['from'];
            $choices = $proficiency['choose'];
            $type = $proficiency['type'];
            $proficiency = collect($listChoices);

            $choiceList = $proficiency->map(function ($item, $key) {
                return $item['name'];
            });
            $currentList = $choiceList->toArray();
            $skillPicks = [];
            while ($choices > 0) {
                $skill = $this->choice(
                    "Pick your {$type},Choice {$choices}:",
                    $currentList
                );

                $currentList = $this->removeFromList($currentList, $skill);
                $this->comment("picked: {$skill}");

                $skillPicks[] = $proficiency->where('name', $skill)->flatten()->toArray();
                $choices--;
            }
            $buildChoices[] = [
                'type' => $type,
                'picked' => $skillPicks,
            ];

        }
        $playerClassBuild['skills'] = $buildChoices;
        return $playerClassBuild;
    }


    protected function stats($client)
    {

        $response = $client->request('GET', 'ability-scores/');
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);
        $stats = collect($body['results']);
        // Point buy
        $points = 27;
        $minStat = 8;
        $maxStat = 15;
        $cost=[
          8=>0,
          9=>1,
          10=>2,
          11=>3,
          12=>4,
          13=>5,
          14=>7,
          15=>9,
        ];
        $headers = $stats->pluck('name')->toArray();
        $data['level']=[];
        foreach ($headers as $stat){
            $data['level'][$stat]=$minStat;
        }

        $this->table($headers,$data );
        $this->error("Points Remaining:\t {$points}");

        // while looking at the points
        while ($points>0){
            $editStat = $this->choice(
                "Pick what Stat to edit:",
                $headers
            );
            // as for stat get number and then set new  number
            $statLevel = $data['level'][$editStat];
            dd($statLevel);
            // Loop
            $input = $this->ask("Set Stat :{$editStat}:");


            dd($editStat);
        }
        dd('this is info');
// Manual way
        $stats = [];
        // build basics name and stats
        foreach ($body['results'] as $item) {

            $input = $this->ask('What is your: ' . $item['name']);
            $stats[] = [
                'name' => $item['name'],
                'value' => $input,
                'url' => $item['url']
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
        ]);

        $playerStats = $this->stats($client);

//        $playerClass = $this->playerClass($client);
//        $url = $playerClass['url'];
//        $playerClass2 = $this->playerClassBuild($client, $url);


//        $playerRace = $this->playerRace($client);
//        $this->playerSubRace($client,$playerRace['url']);


        // Build your Race
        return null;

    }
}
