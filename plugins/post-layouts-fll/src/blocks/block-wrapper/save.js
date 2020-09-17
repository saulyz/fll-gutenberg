import { InnerBlocks } from '@wordpress/block-editor';
import { withSelect } from '@wordpress/data';

const blockWrapperSave = (props) => {
  const { attributes } = props;
  const { bgImageId, bgImageUrl } = attributes;

  let styles;
  if (bgImageUrl) {
    styles = { backgroundImage: `url(${bgImageUrl})` };
  }
  return (
    <div style={styles}>
      <InnerBlocks.Content />
    </div>
  );
}

export default blockWrapperSave;
