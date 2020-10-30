<?php

use Symfony\Component\VarDumper\VarDumper;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

if (! function_exists('factory')) {
    /**
     * Create a factory seeder.
     *
     * @param Model|object|string $model      Instance or name of the model
     * @param int|null            $count      Create factory
     * @param array|null          $formatters Difine faker factory
     * @param array|null          $overrides  Overriding data to pass to Fabricator::setOverrides()
     * @return object|array
     */
    function factory($model, $count = null, ?array $formatters = null, ?array $overrides = null)
    {
        $fabricator = new \CodeIgniter\Test\Fabricator($model, $formatters);

        if (! is_null($overrides)) {
            $fabricator->setOverrides($overrides);
        }

        return $fabricator->create($count);
    }
}

if (! function_exists('dumping')) {
    /**
     * @author Nicolas Grekas <p@tchwork.com>
     */
    function dumping($var, ...$moreVars)
    {
        VarDumper::dump($var);

        foreach ($moreVars as $v) {
            VarDumper::dump($v);
        }

        if (1 < func_num_args()) {
            return func_get_args();
        }

        return $var;
    }
}

if (! function_exists('dump')) {
    function dump(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }
}
