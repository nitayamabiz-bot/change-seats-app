<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TddWatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tdd:watch
                            {--interval=2 : テスト実行の間隔（秒）}
                            {--testsuite= : 実行するテストスイート（Unit または Feature）}
                            {--filter= : 実行するテストのフィルタ}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TDD用: ファイル変更を待ち、定期的にテストを実行する（Ctrl+Cで終了）';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $interval = (int) $this->option('interval');
        $interval = max(1, min(60, $interval));

        $this->info('TDD Watch を開始しました。ファイルを保存するとテストが再実行されます。');
        $this->info("間隔: {$interval}秒 | 終了: Ctrl+C");
        $this->newLine();

        while (true) {
            $args = ['--ansi'];
            if ($suite = $this->option('testsuite')) {
                $args['--testsuite'] = $suite;
            }
            if ($filter = $this->option('filter')) {
                $args['--filter'] = $filter;
            }

            $this->line('--- '.now()->format('H:i:s').' テスト実行 ---');
            $exitCode = $this->call('test', $args);
            $this->newLine();

            if ($exitCode !== 0) {
                $this->error('テストが失敗しました。');
            }

            sleep($interval);
        }
    }
}
