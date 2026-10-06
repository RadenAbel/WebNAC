<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        $this->move('public', 'local');
    }

    public function down(): void
    {
        $this->move('local', 'public');
    }

    private function move(string $from, string $to): void
    {
        $source = Storage::disk($from);
        $target = Storage::disk($to);

        foreach (DB::table('join_requests')->whereNotNull('photo')->pluck('photo') as $path) {
            if ($source->exists($path) && ! $target->exists($path)) {
                $target->put($path, $source->get($path));
                $source->delete($path);
            }
        }
    }
};
