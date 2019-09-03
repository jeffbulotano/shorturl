<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class RedirectUrl extends Model
{   
    /**
     * Rules for validating request data
     * 
     * @var array
     */
    private $rules = [
        'long_url' => 'required'
    ];

    /**
     * hosts to be blocked.
     */
    private $blocked_hosts = [
        'localhost'
    ];

    /**
     * Default URL scheme
     * 
     * @var string 
     */
    private $default_url_scheme = 'http://';

    /**
     * Valid URL schemes
     * 
     * @var array
     */
    private $valid_url_schemes = [
        'http',
        'https'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_url'
    ];

    public function __construct() 
    {
        $this->blocked_hosts[] = parse_url(env('APP_URL'), PHP_URL_HOST);
    }

    /**
     * Run validations on url and return url for external redirection.
     * 
     * @return string
     */
    public function parseUrl($url) 
    {
        $valid_url = $this->setUrlScheme($url);
        $valid_url = $this->validateUrl($valid_url);
        $valid_url = $this->checkBlockedHosts($valid_url);

        return $valid_url;
    }

    /**
     * Set the url scheme if not available
     * 
     * @return string
     */
    private function setUrlScheme($url) 
    {
        $url_scheme = parse_url($url, PHP_URL_SCHEME);
        
        if ($url_scheme && !in_array($url_scheme, $this->valid_url_schemes)) {
            throw new Exception('Invalid URL protocol.');
        }

        return parse_url($url, PHP_URL_SCHEME) ? $url : $this->default_url_scheme . $url;
    }

    /**
     * Validate url using filter_var
     * 
     * @return string
     */
    private function validateUrl($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid URL');
        }
            
        return $url;
    }

    /**
     * Check blocked hosts
     * 
     * @return string
     */
    private function checkBlockedHosts($url) {
        if (in_array($host = parse_url($url, PHP_URL_HOST), $this->blocked_hosts)) {
            throw new Exception('This domain is blocked.');
        }

        return $url;
    }
}