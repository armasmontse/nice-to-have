<?php

namespace App\Notifications\Traits;

use App\Setting;
use App\User;

trait AdminNotificationsTrait {

	public static function AdminNotify(array $args)
	{
		$notify_user = new User(
			[
				"email"	=> Setting::getEmail('notifications')
			]
		);

		$notify_user->notify( new static( $args ));
	}

}
