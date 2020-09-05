import { map } from 'lodash';
import { withSelect } from '@wordpress/data';
import { Placeholder, Spinner } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const PostList = (props) => {
  const { postList, className } = props;
  const hasPosts = Array.isArray(postList) && postList.length;
  if (!hasPosts) {
    return (
      <Placeholder
        icon="excerpt-view"
        label={__('Post Block', '')}
      >
        {!Array.isArray(postList) ? <Spinner /> : __('No posts found.', '')}
      </Placeholder>
    );
  }
  return (
    <div className={className}>
      {
        map(postList, (post) => {
          return (
            <div>{post.title.raw}</div>
          );
        })}
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
    postList: getEntityRecords('postType', 'post', postQuery),
  }
})(PostList)