<?php

$finder = PhpCsFixer\Finder::create()
    ->path('app/')
    ->path('src/')
    ->path('tests/')
    ->path('web/')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true
    ])
    ->setFinder($finder)
;
