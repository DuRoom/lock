<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Lock\Listener;

use DuRoom\Lock\Event\DiscussionWasLocked;
use DuRoom\Lock\Notification\DiscussionLockedBlueprint;
use DuRoom\Lock\Post\DiscussionLockedPost;
use DuRoom\Notification\NotificationSyncer;

class CreatePostWhenDiscussionIsLocked
{
    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(DiscussionWasLocked $event)
    {
        $post = DiscussionLockedPost::reply(
            $event->discussion->id,
            $event->user->id,
            true
        );

        $post = $event->discussion->mergePost($post);

        if ($event->discussion->user_id !== $event->user->id) {
            $notification = new DiscussionLockedBlueprint($post);

            $this->notifications->sync($notification, $post->exists ? [$event->discussion->user] : []);
        }
    }
}
