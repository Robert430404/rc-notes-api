<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Class MakeAdmin
 *
 * @package App\Console\Commands
 */
class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {--name=} {--pass=} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes A New Admin Account';

    /**
     * MakeAdmin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executes the console command when called from the command line
     */
    public function handle()
    {
        $name   = $this->option('name');
        $pass   = $this->option('pass');
        $email  = $this->option('email');

        Validator::make([
            'name'  => $name,
            'pass'  => $pass,
            'email' => $email,
        ], [
            'name'  => 'required|max:255',
            'pass'  => 'required|min:6',
            'email' => 'required|email|max:255',
        ])->validate();

        User::create([
            'name'     => $name,
            'password' => password_hash($pass, PASSWORD_DEFAULT),
            'email'    => $email,
            'api_key'  => password_hash($name . $pass, PASSWORD_DEFAULT )
        ]);

        $this->info('User Created Successfully');
    }
}