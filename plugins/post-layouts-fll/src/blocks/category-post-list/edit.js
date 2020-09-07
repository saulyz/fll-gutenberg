import { map } from 'lodash';
import { __ } from '@wordpress/i18n';
import { withSelect } from '@wordpress/data';
import { Spinner } from '@wordpress/components';
import { RichText } from '@wordpress/block-editor';

const PostList = (props) => {
  const { posts, className, attributes, setAttributes } = props;
  
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
        placeholder={__('Title?')}
      />
      <ul>
        {posts.map(post => {
          return (
            <li>
              <a href={post.link}>
                {post.title.rendered}
              </a>
            </li>
          );
        })}
      </ul>
    </div>
  );
}

export default withSelect((select, ownProps) => {
  const { getEntityRecords } = select('core');
  const postQuery = {
    per_page: 10,
    page: 1
  }
  return {
    posts: getEntityRecords('postType', 'post', postQuery),
  }
})(PostList)