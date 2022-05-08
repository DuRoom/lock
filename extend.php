<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use DuRoom\Api\Serializer\BasicDiscussionSerializer;
use DuRoom\Api\Serializer\DiscussionSerializer;
use DuRoom\Discussion\Discussion;
use DuRoom\Discussion\Event\Saving;
use DuRoom\Discussion\Filter\DiscussionFilterer;
use DuRoom\Discussion\Search\DiscussionSearcher;
use DuRoom\Extend;
use DuRoom\Lock\Access;
use DuRoom\Lock\Event\DiscussionWasLocked;
use DuRoom\Lock\Event\DiscussionWasUnlocked;
use DuRoom\Lock\Listener;
use DuRoom\Lock\Notification\DiscussionLockedBlueprint;
use DuRoom\Lock\Post\DiscussionLockedPost;
use DuRoom\Lock\Query\LockedFilterGambit;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Notification())
        ->type(DiscussionLockedBlueprint::class, BasicDiscussionSerializer::class, ['alert']),

    (new Extend\ApiSerializer(DiscussionSerializer::class))
        ->attribute('isLocked', function (DiscussionSerializer $serializer, Discussion $discussion) {
            return (bool) $discussion->is_locked;
        })
        ->attribute('canLock', function (DiscussionSerializer $serializer, Discussion $discussion) {
            return (bool) $serializer->getActor()->can('lock', $discussion);
        }),

    (new Extend\Post())
        ->type(DiscussionLockedPost::class),

    (new Extend\Event())
        ->listen(Saving::class, Listener\SaveLockedToDatabase::class)
        ->listen(DiscussionWasLocked::class, Listener\CreatePostWhenDiscussionIsLocked::class)
        ->listen(DiscussionWasUnlocked::class, Listener\CreatePostWhenDiscussionIsUnlocked::class),

    (new Extend\Policy())
        ->modelPolicy(Discussion::class, Access\DiscussionPolicy::class),

    (new Extend\Filter(DiscussionFilterer::class))
        ->addFilter(LockedFilterGambit::class),

    (new Extend\SimpleDuRoomSearch(DiscussionSearcher::class))
        ->addGambit(LockedFilterGambit::class),
];
