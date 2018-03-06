<?php

namespace App\Console\Commands;

use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoApproveTopics extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'auto_approve_topics';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Auto-approve topics after 3 days.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$topics = Topic::all();
		$current_time = Carbon::now();
		foreach ($topics as $topic) {
			if ($topic->created_at < $current_time->subDays(3)) {
				$topic->is_approved = true;
				$topic->save();
			}
		}
	}
}
