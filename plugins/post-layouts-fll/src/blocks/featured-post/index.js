import { __ } from '@wordpress/i18n';

import edit from './edit';

export default {
  title: __('Featured post', 'post-layouts-fll'),
  icon: 'star-filled',
  category: 'futurelawlab',
  attributes: {
    blockLabel: {
      type: 'string',
      source: 'children',
      selector: 'h2',
      default: ''
    },
    selectedPostId: {
      type: 'number',
      default: 0
    },
  },
  example: {},
  edit
};