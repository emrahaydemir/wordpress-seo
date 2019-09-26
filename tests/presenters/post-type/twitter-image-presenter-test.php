<?php
/**
 * WPSEO plugin test file.
 */

namespace Yoast\WP\Free\Tests\Presenters\Post_Type;

use Yoast\WP\Free\Helpers\Image_Helper;
use Yoast\WP\Free\Presenters\Post_Type\Twitter_Image_Presenter;
use Yoast\WP\Free\Tests\Doubles\Presenters\Post_Type\Twitter_Image_Presenter_Double;
use Yoast\WP\Free\Tests\TestCase;
use Yoast\WP\Free\Tests\Mocks\Indexable;
use Brain\Monkey;
use Mockery;

/**
 * Class Twitter_Image_Presenter_Test.
 *
 * @coversDefaultClass \Yoast\WP\Free\Presenters\Post_Type\Twitter_Image_Presenter
 *
 * @group twitter
 * @group twitter-image
 */
class Twitter_Image_Presenter_Test extends TestCase {

	/**
	 * Holds the instance of the class being tested.
	 *
	 * @var Twitter_Image_Presenter_Double
	 */
	protected $class_instance;

	/**
	 * Mocked WP_Post.
	 *
	 * @var \WP_Post
	 */
	protected $mock_post;

	/**
	 * @var Image_Helper|\Mockery\MockInterface
	 */
	protected $image_helper_mock;

	/**
	 * Sets up the test instance.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->mock_post               = Mockery::mock( '\WP_Post' )
												->makePartial();
		$this->mock_post->ID           = 1;
		$this->mock_post->post_content = '';

		$this->image_helper_mock = Mockery::mock( Image_Helper::class );
		$this->class_instance    = new Twitter_Image_Presenter_Double( $this->image_helper_mock );
	}

	/**
	 * Tests the generate function when a password is required.
	 *
	 * @covers ::generate
	 */
	public function test_generate_password_required() {
		$indexable = new Indexable();

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( true );

		$image_url = $this->class_instance->generate( $indexable );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving a social image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_social_image() {
		$indexable                = new Indexable();
		$indexable->twitter_image = 'https://example.com/media/image.jpg';

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
			->makePartial()
			->shouldAllowMockingProtectedMethods();

		$instance
			->shouldReceive( 'retrieve_social_image' )
			->with( $indexable )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';
		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving an attachment image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_attachment_image() {
		$indexable                = new Indexable();
		$indexable->twitter_image = 'https://example.com/media/image.jpg';

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
			->makePartial()
			->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();

		$instance
			->shouldReceive( 'retrieve_attachment_image' )
			->with( $indexable->object_id )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';

		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving a featured image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_featured_image() {
		$indexable                = new Indexable();
		$indexable->twitter_image = 'https://example.com/media/image.jpg';

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
						   ->makePartial()
						   ->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_attachment_image' )->andReturnFalse();

		$instance
			->shouldReceive( 'retrieve_featured_image' )
			->with( $indexable->object_id )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';

		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving a gallery image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_gallery_image() {
		$indexable                = new Indexable();
		$indexable->twitter_image = 'https://example.com/media/image.jpg';

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
						   ->makePartial()
						   ->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_attachment_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_featured_image' )->andReturnFalse();

		$instance
			->shouldReceive( 'retrieve_gallery_image' )
			->with( $indexable->object_id )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';

		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving a content image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_content_image() {
		$indexable                = new Indexable();
		$indexable->twitter_image = 'https://example.com/media/image.jpg';

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
						   ->makePartial()
						   ->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_attachment_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_featured_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_gallery_image' )->andReturnFalse();

		$instance
			->shouldReceive( 'retrieve_content_image' )
			->with( $indexable->object_id )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';

		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url by retrieving a default image.
	 *
	 * @covers ::generate
	 */
	public function test_generate_retrieve_default_image() {
		$indexable                = new Indexable();

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
						   ->makePartial()
						   ->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_attachment_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_featured_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_gallery_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_content_image' )->andReturnFalse();

		$instance
			->shouldReceive( 'retrieve_default_image' )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';

		$image_url = $instance->generate( $indexable );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests generating the Twitter image url when there isn't any url.
	 *
	 * @covers ::generate
	 */
	public function test_generate_return_empty_string() {
		$indexable                = new Indexable();

		Monkey\Functions\expect( 'post_password_required' )
			->once()
			->andReturn( false );

		$instance = Mockery::mock( Twitter_Image_Presenter::class )
						   ->makePartial()
						   ->shouldAllowMockingProtectedMethods();

		$instance->shouldReceive( 'retrieve_social_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_attachment_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_featured_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_gallery_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_content_image' )->andReturnFalse();
		$instance->shouldReceive( 'retrieve_default_image' )->andReturnFalse();

		$image_url = $instance->generate( $indexable );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving an attachment page's attachment url when the post type is not attachment.
	 *
	 * @covers ::retrieve_attachment_image
	 */
	public function test_retrieve_attachment_image_post_type_is_not_attachment() {
		Monkey\Functions\expect( 'get_post_type' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'page' );

		$image_url = $this->class_instance->retrieve_attachment_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving an attachment page's attachment url when the image is of an allowed mimetype.
	 *
	 * @covers ::retrieve_attachment_image
	 */
	public function test_retrieve_attachment_image_with_allowed_mimetype() {
		Monkey\Functions\expect( 'get_post_type' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'attachment' );
		Monkey\Functions\expect( 'get_post_mime_type' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'image/jpeg' );
		Monkey\Functions\expect( 'wp_get_attachment_url' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'https://example.com/media/image.jpg' );

		$expected = 'https://example.com/media/image.jpg';
		$image_url = $this->class_instance->retrieve_attachment_image( $this->mock_post->ID );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests retrieving an attachment page's attachment url when the image is not of an allowed mimetype.
	 *
	 * @covers ::retrieve_attachment_image
	 */
	public function test_retrieve_attachment_image_with_nonallowed_mimetype() {
		Monkey\Functions\expect( 'get_post_type' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'attachment' );
		Monkey\Functions\expect( 'get_post_mime_type' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 'image/svg+xml' );

		$image_url = $this->class_instance->retrieve_attachment_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving the featured image url when the post has no image attached.
	 *
	 * @covers ::retrieve_featured_image
	 */
	public function test_retrieve_featured_image_no_post_thumbnail() {
		Monkey\Functions\expect( 'has_post_thumbnail' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( false );

		$image_url = $this->class_instance->retrieve_featured_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving the featured image url when the post has a thumbnail and a full image attached.
	 *
	 * @covers ::retrieve_featured_image
	 */
	public function test_retrieve_featured_image_post_has_thumbnail_and_image_attached() {
		Monkey\Functions\expect( 'has_post_thumbnail' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( true );
		Monkey\Functions\expect( 'apply_filters' )
			->with( 'wpseo_twitter_image_size', 'full' )
			->once()
			->andReturn( 'full' );
		Monkey\Functions\expect( 'get_post_thumbnail_id' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 11 );
		Monkey\Functions\expect( 'wp_get_attachment_image_src' )
			->with( 11, 'full' )
			->once()
			->andReturn( [ 'https://example.com/media/image.jpg', '100px', '200px', false ] );

		$expected = 'https://example.com/media/image.jpg';
		$image_url = $this->class_instance->retrieve_featured_image( $this->mock_post->ID );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests retrieving the featured image url when the post has a thumbnail but no full image attached.
	 *
	 * @covers ::retrieve_featured_image
	 */
	public function test_retrieve_featured_image_post_has_thumbnail() {
		Monkey\Functions\expect( 'has_post_thumbnail' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( true );
		Monkey\Functions\expect( 'apply_filters' )
			->with( 'wpseo_twitter_image_size', 'full' )
			->once()
			->andReturn( 'full' );
		Monkey\Functions\expect( 'get_post_thumbnail_id' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( 11 );
		Monkey\Functions\expect( 'wp_get_attachment_image_src' )
			->with( 11, 'full' )
			->once()
			->andReturn( false );

		$image_url = $this->class_instance->retrieve_featured_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving the first image url of a gallery when there is no gallery.
	 *
	 * @covers ::retrieve_gallery_image
	 */
	public function test_retrieve_gallery_image_when_gallery_is_absent() {
		Monkey\Functions\expect( 'get_post' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( $this->mock_post );
		Monkey\Functions\expect( 'has_shortcode' )
			->with( $this->mock_post->post_content, 'gallery' )
			->once()
			->andReturn( false );
		Monkey\Functions\expect( 'get_post_gallery_images' )
			->never();

		$image_url = $this->class_instance->retrieve_gallery_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving the first image url of a gallery when there is an empty gallery.
	 *
	 * @covers ::retrieve_gallery_image
	 */
	public function test_retrieve_gallery_image_when_gallery_is_empty() {
		Monkey\Functions\expect( 'get_post' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( $this->mock_post );
		Monkey\Functions\expect( 'has_shortcode' )
			->with( $this->mock_post->post_content, 'gallery' )
			->once()
			->andReturn( true );
		Monkey\Functions\expect( 'get_post_gallery_images' )
			->once()
			->andReturn( [] );

		$image_url = $this->class_instance->retrieve_gallery_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}

	/**
	 * Tests retrieving the first image url of a gallery when there is a gallery.
	 *
	 * @covers ::retrieve_gallery_image
	 */
	public function test_retrieve_gallery_image_when_gallery_is_present() {
		Monkey\Functions\expect( 'get_post' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( $this->mock_post );
		Monkey\Functions\expect( 'has_shortcode' )
			->with( $this->mock_post->post_content, 'gallery' )
			->once()
			->andReturn( true );
		Monkey\Functions\expect( 'get_post_gallery_images' )
			->once()
			->andReturn( [ 'https://example.com/media/image.jpg', 'https://example.com/media/image2.jpg' ] );

		$expected = 'https://example.com/media/image.jpg';
		$images = $this->class_instance->retrieve_gallery_image( $this->mock_post->ID );
		$this->assertEquals( $expected, $images );
	}

	/**
	 * Tests retrieving the first image url from the content.
	 *
	 * @covers ::retrieve_content_image
	 */
	public function test_retrieve_content_image() {
		$expected = 'https://example.com/media/content_image.jpg';

		$this->image_helper_mock
			->expects( 'get_first_usable_content_image_for_post' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( $expected );

		$image_url = $this->class_instance->retrieve_content_image( $this->mock_post->ID );
		$this->assertEquals( $expected, $image_url );
	}

	/**
	 * Tests whether an empty string is returned when the content contains no image.
	 *
	 * @covers ::retrieve_content_image
	 */
	public function test_retrieve_content_image_no_image_in_content() {
		$this->image_helper_mock
			->expects( 'get_first_usable_content_image_for_post' )
			->with( $this->mock_post->ID )
			->once()
			->andReturn( null );

		$image_url = $this->class_instance->retrieve_content_image( $this->mock_post->ID );
		$this->assertEmpty( $image_url );
	}
}
