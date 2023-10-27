<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\MediaType\MediaFormDataType;
use App\OpenApi\Schemas\ArticleSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ArticleRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaFormDataType::formData()->schema(
                ArticleSchema::ref()
            )
        );
    }
}
