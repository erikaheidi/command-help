<?php

namespace librarianphp\Help;

use Minicli\App;
use Minicli\Command\CommandCall;
use Minicli\Command\CommandController;
use Minicli\Command\CommandRegistry;

class DefaultController extends CommandController
{
    /** @var  array */
    protected array $commandMap = [];

    public function boot(App $app, CommandCall $input): void
    {
        parent::boot($app, $input);
        $this->commandMap = $app->commandRegistry->getCommandMap();
    }

    public function handle(): void
    {
        $this->info($this->app->getSignature());

        $print_table[] = [ 'Namespace', 'Command' ];

        foreach ($this->commandMap as $command => $sub) {
            if ($command == 'web') {
                continue;
            }
            $print_table[] = [ $command, ''];
            if (is_array($sub)) {
                foreach ($sub as $subcommand) {
                    if ($subcommand == 'default') {
                        $row = "./librarian $command\n";
                    } else {
                        $row = "./librarian $command $subcommand\n";
                    }

                    $print_table[] = [ '', $row ];
                }
            }
        }

        $this->printTable($print_table);
    }
}
