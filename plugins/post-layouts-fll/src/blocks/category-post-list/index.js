import { __ } from '@wordpress/i18n';

import edit from './edit';

export default {
  title: __('Category Post List', 'post-layouts-fll'),
  icon: 'star-filled',
  category: 'futurelawlab',
  example: {},
  edit,
  save() {
    return (
      <div>
        Category post list
      </div>
    );
  }
}