import app from 'duroom/admin/app';

app.initializers.add('lock', () => {
  app.extensionData.for('duroom-lock').registerPermission(
    {
      icon: 'fas fa-lock',
      label: app.translator.trans('duroom-lock.admin.permissions.lock_discussions_label'),
      permission: 'discussion.lock',
    },
    'moderate',
    95
  );
});
