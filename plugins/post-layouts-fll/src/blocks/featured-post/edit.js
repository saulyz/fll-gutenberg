import { map } from 'lodash';
import { __ } from '@wordpress/i18n';
import { withSelect } from '@wordpress/data';
import { Spinner, SelectControl } from '@wordpress/components';
import { RichText } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';


const FeaturedPost = (props) => {
  const { attributes, setAttributes, posts, className } = props;

  if (!posts) {
    return <p className={className}>
      <Spinner />
      {__('Loading Posts')}
    </p>;
  }
  if (0 === posts.length) {
    return <p>{__('No Posts')}</p>;
  }

  const optionsList = map(posts, (post) => {
    return { label: post.title.raw, value: post.id };
  });
  optionsList.unshift({ label: '- select a post -', value: 0 });
 
  return (
    <div className={className}>
      <RichText
        tagName="h2"
        value={attributes.content}
        onChange={content => setAttributes({ content })}
        placeholder={__('Title?')}
      />
      <p>Post to showcase</p>
      <SelectControl
        value={attributes.postId}
        options={optionsList}
        onChange={postId => props.setAttributes({ postId })}
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