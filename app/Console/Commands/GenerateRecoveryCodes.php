<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateRecoveryCodes extends Command
{
    // Nama perintah artisan
    protected $signature = 'recovery:generate {count=10}';
    protected $description = 'Generate recovery codes dan simpan ke config/recovery.php';

    public function handle()
    {
        $count = (int) $this->argument('count');
        $used = [];
        $codes = [];

        // Generate kode unik
        for ($i = 1; $i <= $count; $i++) {
            do {
                $code = strtoupper(bin2hex(random_bytes(2))) . '-' .
                        strtoupper(bin2hex(random_bytes(2))) . '-' .
                        strtoupper(bin2hex(random_bytes(2)));
            } while (in_array($code, $used));
            $used[] = $code;
            $codes[] = $code;
        }

        // Path config & file used codes
        $configPath = config_path('recovery.php');
        $usedCodesPath = storage_path('app/used_recovery_codes.json');

        // Simpan kode ke config/recovery.php
        $content = "<?php\nreturn [\n    'admin_codes' => [\n";
        foreach ($codes as $c) {
            $content .= "        '$c',\n";
        }
        $content .= "    ],\n];\n";
        file_put_contents($configPath, $content);

        // Reset daftar kode yang sudah dipakai
        file_put_contents($usedCodesPath, json_encode([]));

        $this->info("✅ $count recovery code baru berhasil dibuat di config/recovery.php");
        $this->info("ℹ️  used_recovery_codes.json sudah direset");
    }
}
