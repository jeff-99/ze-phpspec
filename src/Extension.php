<?php


namespace ZEPHPSpec;

use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;
use ZEPHPSpec\Matcher\ResponseMatcher;

class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('zephpspec.matchers.return_response', function ($c) {
            return new ResponseMatcher($c->get('formatter.presenter'));
        }, ['matchers']);

    }
}
