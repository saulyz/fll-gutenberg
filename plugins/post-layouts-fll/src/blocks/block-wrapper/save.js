import { InnerBlocks } from '@wordpress/block-editor';

const blockWrapperSave = (props) => {
  const { attributes } = props;
  const { bgImageId, bgImageUrl, alignmentClass } = attributes;

  console.log('blockWrapperSave', props);

  let styles;
  if (bgImageUrl) {
    styles = { backgroundImage: `url(${bgImageUrl})` };
  }
  return (
    <div className={alignmentClass} style={styles}>
      <InnerBlocks.Content />
    </div>
  );
}

export default blockWrapperSave;
