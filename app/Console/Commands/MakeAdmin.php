<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
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
        $name     = $this->option('name');
        $password = $this->option('pass');
        $email    = $this->option('email');

        Validator::make([
            'name'  => $name,
            'password'  => $password,
            'email' => $email,
        ], [
            'name'  => 'required|max:255',
            'password'  => 'required|min:6',
            'email' => 'required|email|max:255',
        ])->validate();

        $user             = new User();
        $apiKey           = password_hash($name . $password, PASSWORD_DEFAULT );
        $user->name       = $name;
        $user->password   = $password;
        $user->email      = $email;
        $user->api_key    = $apiKey;
        $user->created_at = Carbon::now();

        $user->save();
        $this->info("Your API Key Is: $apiKey");
        $this->info('User Created Successfully');
    }
}