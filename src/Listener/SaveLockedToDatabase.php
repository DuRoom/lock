<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Lock\Listener;

use DuRoom\Discussion\Event\Saving;
use DuRoom\Lock\Event\DiscussionWasLocked;
use DuRoom\Lock\Event\DiscussionWasUnlocked;

class SaveLockedToDatabase
{
    public function handle(Saving $event)
    {
        if (isset($event->data['attributes']['isLocked'])) {
            $isLocked = (bool) $event->data['attributes']['isLocked'];
            $discussion = $event->discussion;
            $actor = $event->actor;

            $actor->assertCan('lock', $discussion);

            if ((bool) $discussion->is_locked === $isLocked) {
                return;
            }

            $discussion->is_locked = $isLocked;

            $discussion->raise(
                $discussion->is_locked
                    ? new DiscussionWasLocked($discussion, $actor)
                    : new DiscussionWasUnlocked($discussion, $actor)
            );
        }
    }
}
