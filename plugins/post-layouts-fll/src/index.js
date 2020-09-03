import { registerBlockType } from '@wordpress/blocks';
import { withSelect } from '@wordpress/data';

(function (blocks, i18n, element) {
  var el = element.createElement;
  var __ = i18n.__;

  registerBlockType('post-layouts-fll/featured-post', {
    title: __( 'Featured post', 'post-layouts-fll'),
    icon: 'star-filled',
    category: 'design',
    example: {},
    edit: withSelect((select) => {
      return {
        posts: select('core').getEntityRecords('postType', 'post'),
      };
    })(({ posts, className }) => {
      if (!posts) {
        return 'Loading...';
      }

      if (posts && posts.length === 0) {
        return 'No posts';
      }

      const post = posts[0];

      return (
        <div className={className}>
          <a href={post.link}>
            {post.title.rendered}
          </a>    
        </div>
      );
    })
  });

})(window.wp.blocks, window.wp.i18n, window.wp.element);