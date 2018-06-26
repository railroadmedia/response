<?php

if (! function_exists('reply')) {
    /**
     */
    function reply()
    {
        return app('fractal.response');
    }
}
