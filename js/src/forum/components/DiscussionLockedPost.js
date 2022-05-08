import EventPost from 'duroom/forum/components/EventPost';

export default class DiscussionLockedPost extends EventPost {
  icon() {
    return this.attrs.post.content().locked ? 'fas fa-lock' : 'fas fa-unlock';
  }

  descriptionKey() {
    return this.attrs.post.content().locked
      ? 'duroom-lock.forum.post_stream.discussion_locked_text'
      : 'duroom-lock.forum.post_stream.discussion_unlocked_text';
  }
}
