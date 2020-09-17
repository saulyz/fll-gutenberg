import { registerBlockType } from '@wordpress/blocks';

import featuredPost from './blocks/featured-post';
import categoryPostList from './blocks/category-post-list';
import blockWrapper from './blocks/block-wrapper';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';


// todo - define a FLL block category for block grouping

registerBlockType('post-layouts-fll/featured-post', featuredPost);
registerBlockType('post-layouts-fll/category-post-list', categoryPostList);
registerBlockType('post-layouts-fll/block-wrapper', blockWrapper);
