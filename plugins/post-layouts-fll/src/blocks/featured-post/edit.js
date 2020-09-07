import { map } from 'lodash';
import { withSelect } from '@wordpress/data';
import { RichText, SelectControl } from '@wordpress/components';

const FeaturedPost = (props) => {
  const { attributes: { blockLabel, selectedPostId }, setAttributes, posts, className } = props;

  console.log('FeaturedPost: props', props, blockLabel, selectedPostId);

  if (!posts) {
    return 'Loading...';
  }

  if (posts && posts.length === 0) {
    return 'No posts';
  }

  console.log('FeaturedPost: posts', posts);

  const optionsList = map(posts, (post) => {
    return { label: post.title.raw, value: post.id };
  });
  optionsList.unshift({ label: 'select a post', value: 0 });

  return (
    <div className={className}>
      <SelectControl
        label='Post'
        value={selectedPostId}
        options={optionsList}
        onChange={(val) => props.setAttributes({ selectedPostId: val })}
      />
    </div>
  );
    
};

export default withSelect((select, ownProps) => {
  const { getEntityRecords } = select('core');
  return {
    posts: getEntityRecords('postType', 'post', { per_page: -1 }),
  }
})(FeaturedPost)