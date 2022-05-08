<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Lock\Access;

use DuRoom\Discussion\Discussion;
use DuRoom\User\Access\AbstractPolicy;
use DuRoom\User\User;

class DiscussionPolicy extends AbstractPolicy
{
    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function reply(User $actor, Discussion $discussion)
    {
        if ($discussion->is_locked && $actor->cannot('lock', $discussion)) {
            return $this->deny();
        }
    }
}
