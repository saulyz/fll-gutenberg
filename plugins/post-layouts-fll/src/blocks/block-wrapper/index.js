import { __ } from '@wordpress/i18n';


import edit from './edit';
import save from './save';

export default {
  title: __('Wrapper block', 'post-layouts-fll'),
  icon: 'star-filled',
  category: 'futurelawlab',
  supports: {
    align: ['full'],
  },
  attributes: {
    bgImageId: {
      type: 'number',
    },
    bgImageUrl: {
      type: 'string',
    },
    alignmentClass: {
      type: 'string',
    },
  },
  edit,
  save
}