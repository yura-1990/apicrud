<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\UserFieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UserRegisterRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->description('user date')->content(
            MediaType::json()->schema(
                UserFieldSchema::ref()
            )
        );
    }
}
