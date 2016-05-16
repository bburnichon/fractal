<?php


namespace Serializer;


use League\Fractal\Manager;
use League\Fractal\Resource\NullResource;
use League\Fractal\Scope;
use League\Fractal\Serializer\ExplicitNullArraySerializer;
use League\Fractal\Test\Stub\Transformer\GenericBookTransformer;

class ExplicitNullArraySerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerializingNullResource()
    {
        $manager = new Manager();
        $manager->parseIncludes('author');
        $manager->setSerializer(new ExplicitNullArraySerializer());

        $resource = new NullResource(null, new GenericBookTransformer(), 'books');

        // Try without metadata
        $scope = new Scope($manager, $resource);

        $expected = null;
        $this->assertSame($expected, $scope->toArray());

        // JSON array of JSON objects
        $expectedJson = 'null';
        $this->assertSame($expectedJson, $scope->toJson());

        // Same again with metadata
        $resource->setMetaValue('foo', 'bar');
        $scope = new Scope($manager, $resource);

        $expected = null;
        $this->assertSame($expected, $scope->toArray());

        $expectedJson = 'null';
        $this->assertSame($expectedJson, $scope->toJson());
    }
}
