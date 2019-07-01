<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Models\Events\Event;
use App\Notifications\Users\Events\FinishEventCheckoutNotification;

class FinishEventCheckoutReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:remind-finish-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind users to checkout its closed event bag.';

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
        $events = Event::whereHas('bags', function($query){
            return $query->whereHas('bagType', function($q){
                return $q->where([
                    ['event', '=', true],
                    ['special', '=', true],
                    ['protected', '=', false],
                ]);
            })->whereHas('bagStatus', function($the_query){
                return $the_query->where([
                    ['active', '=', true],
                    ['paid', '=', false],
                    ['cancel', '=', false],
                ]);
            });
        })->whereHas('eventStatus', function($q){
            $q->where([
                ['active', '=', false],
                ['publish', '=', true],
            ]);
        })->get();

        foreach ($events as $event) {

            $bag = $event->getCloseBag();

            if ($bag) {
                $event->user->notify( new FinishEventCheckoutNotification($bag));
            }

        }
    }
}
