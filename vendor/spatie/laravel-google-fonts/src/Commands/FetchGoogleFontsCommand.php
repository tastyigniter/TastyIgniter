<?php

namespace Spatie\GoogleFonts\Commands;

use Illuminate\Console\Command;
use Spatie\GoogleFonts\GoogleFonts;

class FetchGoogleFontsCommand extends Command
{
    public $signature = 'google-fonts:fetch {--new-fonts-only : only download the fonts which are not already cached}';

    public $description = 'Fetch Google Fonts and store them on a local disk';

    public function handle()
    {
        $newFontsOnly = $this->option('new-fonts-only');

        $this->info('Start fetching Google Fonts...');

        collect(config('google-fonts.fonts'))
            ->keys()
            ->each(function (string $font) use ($newFontsOnly) {
                $this->info("Fetching `{$font}`...");

                app(GoogleFonts::class)->load(compact('font'), forceDownload: ! $newFontsOnly);
            });

        $this->info('All done!');
    }
}
