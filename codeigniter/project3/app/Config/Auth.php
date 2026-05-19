<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;
use Myth\Auth\Config\Auth as AuthConfig;
class Auth extends AuthConfig
{
    public $requireActivation = null;
    
    public $landingRoute = '/admin';

    public $views = [
        'login'           => 'App\Views\Auth\login',
        'register'        => 'App\Views\Auth\register',
        'forgot'          => 'App\Views\Auth\forgot',
        'reset'           => 'Myth\Auth\Views\reset',
        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];
}