import { withSelect } from '@wordpress/data';

const FeaturedPost = (props) => {
  const { posts, className } = props;

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
    
};

export default withSelect((select, ownProps) => {
  const { getEntityRecords } = select('core ');
  return {
    posts: getEntityRecords('postType', 'post'),
  }
})(FeaturedPost)