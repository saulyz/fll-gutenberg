import { InnerBlocks } from '@wordpress/block-editor';

const blockWrapperSave = (props) => {
  const { attributes } = props;
  const { bgImageId, bgImageUrl, alignmentClass, hasFixedContainer } = attributes;

  // todo - remove
  console.log('blockWrapperSave', props);

  let styles;
  if (bgImageUrl) {
    styles = { backgroundImage: `url(${bgImageUrl})` };
  }
  const containerClass = (hasFixedContainer) ? 'has-fixed-container' : null;
  const blockClasses = [alignmentClass, containerClass].join(' ');
  
  return (
    <div className={blockClasses} style={styles}>
      <InnerBlocks.Content />
    </div>
  );
}

export default blockWrapperSave;
