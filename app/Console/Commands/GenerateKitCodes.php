<?php

namespace App\Console\Commands;

use App\Models\KitActivationCode;
use App\Models\TinkeringModule;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateKitCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tinkering:generate-codes {prefix} {quantity} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate kit activation codes with specified prefix and quantity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefix = strtoupper($this->argument('prefix'));
        $quantity = (int) $this->argument('quantity');
        $moduleId = $this->option('module');

        // Validate prefix format
        if (!preg_match('/^[A-Z]{2}$/', $prefix)) {
            $this->error('Prefix must be exactly 2 uppercase letters (e.g., TE, TP)');
            return 1;
        }

        // Validate quantity
        if ($quantity <= 0 || $quantity > 1000) {
            $this->error('Quantity must be between 1 and 1000');
            return 1;
        }

        // Validate module if provided
        $module = null;
        if ($moduleId) {
            $module = TinkeringModule::find($moduleId);
            if (!$module) {
                $this->error("Module with ID {$moduleId} not found");
                return 1;
            }
        }

        // Get the highest existing code number for this prefix
        $lastCode = KitActivationCode::where('code', 'like', $prefix . '-%')
            ->orderBy('code', 'desc')
            ->first();

        $startNumber = 1;
        if ($lastCode) {
            $lastNumber = (int) substr($lastCode->code, 3);
            $startNumber = $lastNumber + 1;
        }

        $this->info("Generating {$quantity} codes with prefix {$prefix}...");

        $codes = [];
        for ($i = 0; $i < $quantity; $i++) {
            $number = $startNumber + $i;
            $code = $prefix . '-' . str_pad($number, 6, '0', STR_PAD_LEFT);
            
            // Check if code already exists
            if (KitActivationCode::where('code', $code)->exists()) {
                $this->warn("Code {$code} already exists, skipping...");
                continue;
            }

            $codes[] = [
                'code' => $code,
                'status' => 'unused',
                'module_id' => $module?->id,
                'generated_by' => 1, // Default to admin user ID 1
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert codes in batches
        $chunks = array_chunk($codes, 100);
        foreach ($chunks as $chunk) {
            KitActivationCode::insert($chunk);
        }

        $this->info("Successfully generated " . count($codes) . " codes:");
        
        foreach (array_slice($codes, 0, 10) as $code) {
            $this->line("  - {$code['code']}");
        }

        if (count($codes) > 10) {
            $this->line("  ... and " . (count($codes) - 10) . " more");
        }

        return 0;
    }
}
