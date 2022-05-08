import app from 'duroom/forum/app';
import { extend } from 'duroom/common/extend';
import Discussion from 'duroom/common/models/Discussion';
import Badge from 'duroom/common/components/Badge';

export default function addLockBadge() {
  extend(Discussion.prototype, 'badges', function (badges) {
    if (this.isLocked()) {
      badges.add(
        'locked',
        Badge.component({
          type: 'locked',
          label: app.translator.trans('duroom-lock.forum.badge.locked_tooltip'),
          icon: 'fas fa-lock',
        })
      );
    }
  });
}
