<?php

/*
 * This file is part of DuRoom.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Lock\Notification;

use DuRoom\Discussion\Discussion;
use DuRoom\Lock\Post\DiscussionLockedPost;
use DuRoom\Notification\Blueprint\BlueprintInterface;

class DiscussionLockedBlueprint implements BlueprintInterface
{
    /**
     * @var DiscussionLockedPost
     */
    protected $post;

    /**
     * @param DiscussionLockedPost $post
     */
    public function __construct(DiscussionLockedPost $post)
    {
        $this->post = $post;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromUser()
    {
        return $this->post->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->post->discussion;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return ['postNumber' => (int) $this->post->number];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'discussionLocked';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Discussion::class;
    }
}
