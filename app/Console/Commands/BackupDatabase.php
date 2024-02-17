<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Backup the database';

    public function handle()
{
    // Define the path where you want to store the backup file
    $backupPath = storage_path('app/backups/') . 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

    // Create a temporary options file to store the database connection options, including the password
    $optionsFile = tempnam(sys_get_temp_dir(), 'mysql_backup');
    file_put_contents($optionsFile, sprintf(
        "[client]\nhost=%s\nuser=%s\npassword=%s",
        env('DB_HOST'),
        env('DB_USERNAME'),
        env('DB_PASSWORD')
    ));

    // Build the command to perform the database export using the options file
    $command = sprintf(
        'mysqldump --defaults-extra-file=%s %s > %s 2>&1',
        escapeshellarg($optionsFile),
        escapeshellarg(env('DB_DATABASE')),
        escapeshellarg($backupPath)
    );

    // Execute the command and capture the output
    exec($command, $output, $returnCode);

    // Delete the temporary options file
    unlink($optionsFile);

    // Check if the command executed successfully
    if ($returnCode !== 0) {
        $this->error('Database backup failed: ' . implode("\n", $output));
        return 1; // Returning non-zero exit code to indicate failure
    }

    // Check if the backup file was created successfully
    if (!file_exists($backupPath)) {
        $this->error('Database backup file was not created.');
        return 1; // Returning non-zero exit code to indicate failure
    }

    $this->info('Database backup completed: ' . $backupPath);
    return 0; // Returning zero exit code to indicate success
}


}
