<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class WriteableLink extends BaseCommand
{
    /**
     * Command grouping.
     *
     * @var string
     */
    protected $group = 'Writeable';

    /**
     * The command's name.
     *
     * @var string
     */
    protected $name = 'writeable:link';

    /**
     * The command's short description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "writeable/app/public" to "public/writeable"';

    /**
     * The command's usage.
     *
     * @var string
     */
    protected $usage = 'writeable:link';

    /**
     * Execute the console command.
     *
     * @param array $parrams
     *
     * @return void
     */
    public function run(array $params)
    {
        if (file_exists(ROOTPATH . 'public/writable')) {
            CLI::error('The "public/writable" directory already exists.');
            return;
        }

        $this->link(ROOTPATH . 'writable/app/public', ROOTPATH . 'public/writable');

        CLI::write(CLI::color('The [public/writeable] directory has been linked.', 'green'));
    }

    /**
     * Create a symlink to the target file or directory. On Windows, a hard link is created if the target is a file.
     *
     * @param string $target
     * @param string $link
     * @return void
     */
    protected function link($target, $link)
    {
        if (! PHP_OS_FAMILY === 'Windows') {
            return symlink($target, $link);
        }

        $mode = is_dir($target) ? 'J' : 'H';

        exec("mklink /{$mode} " . escapeshellarg($link) . ' ' . escapeshellarg($target));
    }
}
