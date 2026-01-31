<?php

namespace App\Providers;

use App\Console\Commands\TddWatchCommand;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->commands([
            TddWatchCommand::class,
        ]);

        RedirectIfAuthenticated::redirectUsing(fn ($request) => route('home'));

        $this->ensureViteBuildForLocal();
    }

    /**
     * ローカルで Vite マニフェストがない場合にスタブを生成し、Herd 等で開いてもクラッシュしないようにする。
     */
    private function ensureViteBuildForLocal(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            return;
        }

        $buildDir = public_path('build');
        $assetsDir = $buildDir.'/assets';
        if (! is_dir($assetsDir)) {
            mkdir($assetsDir, 0755, true);
        }

        $placeholderCss = $assetsDir.'/placeholder.css';
        $placeholderJs = $assetsDir.'/placeholder.js';
        if (! file_exists($placeholderCss)) {
            file_put_contents($placeholderCss, '/* placeholder */');
        }
        if (! file_exists($placeholderJs)) {
            file_put_contents($placeholderJs, '/* placeholder */');
        }

        $manifest = [
            'resources/css/app.css' => [
                'file' => 'assets/placeholder.css',
                'isEntry' => true,
            ],
            'resources/js/app.js' => [
                'file' => 'assets/placeholder.js',
                'isEntry' => true,
            ],
        ];
        file_put_contents($manifestPath, json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
