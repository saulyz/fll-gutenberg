import { map } from 'lodash';
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { InspectorControls, RichText } from '@wordpress/block-editor';
import { Spinner, PanelBody, PanelRow, Button, SelectControl, ToggleControl } from '@wordpress/components';
import { withSelect } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

const PostList = (props) => {
  const { categories, className, attributes, setAttributes } = props;
  
  // get all the posts available
  let allPosts;
  wp.apiFetch({ path: "/wp/v2/posts" }).then(posts => {
    console.log('allPosts', posts);
    allPosts = posts;
  }).catch(() => {
    return;
  });

  let posts = [];
  
  
  // console.log('PostList', posts, categories, attributes);
  console.log('PostList', props);

  const { categoryId, totalPosts } = attributes;
  let categoryOptions = [];
  if (props.categories) {
    categoryOptions.push({ value: 0, label: __('Select a category', 'post-layout-fll') });
    props.categories.forEach(cat => {
      categoryOptions.push({ value: cat.id, label: cat.name });
    });
  } else {
    categoryOptions.push({ value: 0, label: __('Loading...', 'post-layout-fll') })
  }

  const onCategorySelect = (categoryId) => {
    if (allPosts) {
      posts = allPosts.filter( post => {
        console.log('filter:', post.categories);
        return post.categories.includes(parseInt(categoryId));
      });
    }
    console.log('onCategorySelect', categoryId, allPosts, posts);
    setAttributes({
      categoryId: categoryId,
    });
  };
  

  return (
    <Fragment>
      <InspectorControls>
        <PanelBody
          title={__('Post list settings', 'post-layout-fll')}
          initialOpen={true}
        >
          {!categories && <Spinner />}
          {categories &&
            <PanelRow>
              <SelectControl
                label='Category'
                value={attributes.categoryId}
                options={categoryOptions}
                onChange={onCategorySelect}
              />
            </PanelRow>
          }
        </PanelBody>
      </InspectorControls>
      <div className={className}>
        <RichText
          tagName="h2"
          value={attributes.content}
          onChange={content => setAttributes({ content })}
          placeholder={__('Title?')}
        />
        <ul>
          {!!posts && posts.map(post => {
            return (
              <li>
                <a href={post.link}>
                  {post.title.rendered}
                </a>
              </li>
            );
          })}
          {!!posts && 
            <li>{__('No Posts')}</li>
          }
        </ul>
      </div>
    </Fragment>
  );
}

export default withSelect((select, ownProps) => {
  const { getEntityRecords } = select('core');
  const categoryQuery = {
    per_page: -1
  }
  return {
    categories: getEntityRecords('taxonomy', 'category', categoryQuery)
  }
})(PostList)