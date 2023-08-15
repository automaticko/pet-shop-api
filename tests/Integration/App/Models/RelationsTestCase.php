<?php

namespace Tests\Integration\App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

abstract class RelationsTestCase extends TestCase
{
    use RefreshDatabase;

    const COUNT = 10;

    /**
     * @param Collection<int, \Illuminate\Database\Eloquent\Model> $related
     * @param string                                               $class
     * @param callable|null                                        $callback
     * @param int                                                  $count
     *
     * @return void
     */
    protected function assertCorrectRelation(
        Collection $related,
        string $class,
        ?callable $callback = null,
        int $count = self::COUNT
    ): void {
        $this->assertCount($count, $related, "{$class} instances expected");
        if ($callback) {
            $this->assertCount($count, $related->filter($callback), "{$class} instances expected");
        }

        if (!$related->isEmpty()) {
            $this->assertCollectionOfClass($class, $related);
        }
    }

    /**
     * @param string                                               $expected
     * @param Collection<int, \Illuminate\Database\Eloquent\Model> $collection
     * @param string                                               $message
     *
     * @return void
     */
    public function assertCollectionOfClass(string $expected, Collection $collection, string $message = ''): void
    {
        $this->assertTrue(class_exists($expected), "Class {$expected} doesn't exist.");

        $message = $message ?: "Failed asserting that all elements in the collection are instances of {$expected}";

        $this->assertCount($collection->count(), $collection->whereInstanceOf($expected), $message);
    }
}
