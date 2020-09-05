import { registerBlockType } from '@wordpress/blocks';

import featuredPost from './blocks/featured-post';
import categoryPostList from './blocks/category-post-list';

// todo - define a FLL block category for block grouping

registerBlockType('post-layouts-fll/featured-post', featuredPost);
registerBlockType('post-layouts-fll/category-post-list', categoryPostList);
