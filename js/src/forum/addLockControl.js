import app from 'duroom/forum/app';
import { extend } from 'duroom/common/extend';
import DiscussionControls from 'duroom/forum/utils/DiscussionControls';
import DiscussionPage from 'duroom/forum/components/DiscussionPage';
import Button from 'duroom/common/components/Button';

export default function addLockControl() {
  extend(DiscussionControls, 'moderationControls', function (items, discussion) {
    if (discussion.canLock()) {
      items.add(
        'lock',
        Button.component(
          {
            icon: 'fas fa-lock',
            onclick: this.lockAction.bind(discussion),
          },
          app.translator.trans(
            discussion.isLocked() ? 'duroom-lock.forum.discussion_controls.unlock_button' : 'duroom-lock.forum.discussion_controls.lock_button'
          )
        )
      );
    }
  });

  DiscussionControls.lockAction = function () {
    this.save({ isLocked: !this.isLocked() }).then(() => {
      if (app.current.matches(DiscussionPage)) {
        app.current.get('stream').update();
      }

      m.redraw();
    });
  };
}
