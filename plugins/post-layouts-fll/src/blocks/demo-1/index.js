import { __ } from '@wordpress/i18n';
import { withSelect } from '@wordpress/data';
import { Spinner } from '@wordpress/components';
import { RichText } from '@wordpress/block-editor';

export default {
  title: __('Demo-1', 'post-layouts-fll'),
  icon: 'star-filled',
  category: 'futurelawlab',
  example: {},
  
  edit: withSelect(select => {
    return {
      posts: select('core').getEntityRecords('postType', 'post', {
        per_page: 3
      })
    };
  })(({ posts, className, attributes, setAttributes }) => {
    if (!posts) {
      return <p className={className}>
        <Spinner />
        {__('Loading Posts')}
      </p>;
    }
    if (0 === posts.length) {
      return <p>{__('No Posts')}</p>;
    }
    return (
      <div className={className}>
        <RichText
          tagName="h2"
          value={attributes.content}
          onChange={content => setAttributes({ content })}
          placeholder={__('What up, bruh?')}
        />
        <ul>
          {posts.map(post => {
            return (
              <li>
                <a className={className} href={post.link}>
                  {post.title.rendered}
                </a>
              </li>
            );
          })}
        </ul>
      </div>
    );
  } // end withSelect
  ), // end edit
}