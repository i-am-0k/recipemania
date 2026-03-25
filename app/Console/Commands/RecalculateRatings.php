<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use Illuminate\Console\Command;

class RecalculateRatings extends Command
{
    protected $signature = 'ratings:recalculate';
    protected $description = 'Recalculate average ratings for all recipes';

    public function handle()
    {
        $this->info('Recalculating ratings...');

        $recipes = Recipe::all();
        $bar = $this->output->createProgressBar(count($recipes));

        foreach ($recipes as $recipe) {
            $recipe->updateAverageRating();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Ratings recalculated successfully!');
    }
}
