import { registerBlockType } from '@wordpress/blocks';

(function (blocks, i18n, element) {
  var el = element.createElement;
  var __ = i18n.__;

  registerBlockType('post-layouts-fll/featured-post', {
    title: __( 'Featured post', 'post-layouts-fll'),
    icon: 'star-filled',
    category: 'design',
    example: {},
    edit: function (props) {
      return el(
        'p',
        { className: props.className },
        'Featured post (from the editor, in green).'
      );
    },
    save: function () {
      return el(
        'p',
        {},
        'Featured post (from the frontend, in red).'
      );
    },
  });

})(window.wp.blocks, window.wp.i18n, window.wp.element);