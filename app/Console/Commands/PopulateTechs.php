<?php

namespace App\Console\Commands;

use App\Models\Tech;
use App\Models\TechTag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PopulateTechs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-techs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate technologies from builtwith';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://pro.builtwith.com/generic.asmx?T=TECH&INIT=true';
        Log::info($url);

        try {
            $response = json_decode(file_get_contents($url), true);
            foreach ($response as $tech) {
                $techTag = TechTag::firstOrCreate([
                    'name' => $tech['tag']
                ]);
                var_dump('tag id : ' . $techTag->id);
                Tech::firstOrCreate([
                    'name' => $tech['name'],
                    'tech_tag_id' => $techTag->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
