<?php namespace App\Http\Controllers;

use App;
use App\Album;
use App\Services\Providers\ProviderResolver;
use Cache;
use Carbon\Carbon;
use Common\Core\Controller;
use Common\Settings\Settings;
use Illuminate\Http\JsonResponse;

class NewReleasesController extends Controller
{
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var ProviderResolver
     */
    private $resolver;

    /**
     * @param Settings $settings
     * @param ProviderResolver $resolver
     */
    public function __construct(Settings $settings, ProviderResolver $resolver)
    {
        $this->settings = $settings;
        $this->resolver = $resolver;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('index', Album::class);

        $albums = Cache::remember('albums.latest', $this->getCacheTime(), function() {
            $albums = $this->resolver->get('new_releases')->getNewReleases();
            return ! empty($albums) ? $albums : null;
        });

        $options = [
            'prerender' => [
                'view' => 'album.index',
                'config' => 'album.new-releases'
            ]
        ];

        return $this->success(['albums' => $albums], 200, $options);
    }

    /**
     * @return Carbon
     */
    private function getCacheTime()
    {
        return Carbon::now()->addDays($this->settings->get('cache.homepage_days'));
    }
}