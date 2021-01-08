<?php
use tad\FunctionMocker\FunctionMocker;

class RandomPostTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    /**
     * @var string
     */
    protected $root_dir;

    public function setUp(): void
    {
        // Before...
        parent::setUp();

        // Your set up methods here.
        $this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

    // Tests
    public function test_it_works()
    {
        $post = static::factory()->post->create_and_get();
        $this->assertInstanceOf(\WP_Post::class, $post);
    }
}
