<?php

function son_response($content = '', $status = 200, array $headers = [])
{
    $factory = new \App\Http\ResponseFactory();
    //funçao do php, funçao de numero de argumentos
    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->make($content, $status, $headers);
}