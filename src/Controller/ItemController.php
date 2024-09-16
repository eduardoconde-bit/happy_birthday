<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ItemController
{
    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write("List of items");
        return $response;
    }

    public function create(Request $request, Response $response, $args)
    {
        $response->getBody()->write("Create a new item");
        return $response;
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $response->getBody()->write("Update item with ID $id");
        return $response;
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $response->getBody()->write("Delete item with ID $id");
        return $response;
    }
}
