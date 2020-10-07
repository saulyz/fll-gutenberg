import { __ } from '@wordpress/i18n';

import edit from './edit';

export default {
  title: __('Category Post List', 'post-layouts-fll'),
  icon: 'star-filled',
  category: 'futurelawlab',
  attributes: {
    categoryId: {
      type: 'number',
    },
    totalPosts: {
      type: 'string',
    },
  },
  edit

  // server-side render on save using dynamic render callback
}