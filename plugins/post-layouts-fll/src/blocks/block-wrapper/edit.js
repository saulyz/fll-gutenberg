import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { InspectorControls, InnerBlocks, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, PanelRow, Button, ResponsiveWrapper, Spinner, SelectControl, ToggleControl } from '@wordpress/components';
import { withSelect } from '@wordpress/data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

const ALLOWED_MEDIA_TYPES = ['image'];

const BlockWrapperEdit = (props) => {
  const { attributes, setAttributes, bgImage, className } = props;
  const { bgImageId, bgImageUrl, alignmentClass, hasFixedContainer, paddingClass } = attributes;
  const instructions = <p>{__('To edit the background image, you need permission to upload media.', 'post-layout-fll')}</p>;

  let styles = {};
  if (bgImage && bgImage.source_url) {
    styles = { backgroundImage: `url(${bgImage.source_url})` };
  }

  const onUpdateImage = (image) => {
    setAttributes({
      bgImageId: image.id,
      bgImageUrl: image.url,
    });
  };

  const onRemoveImage = () => {
    setAttributes({
      bgImageId: undefined,
      bgImageUrl: undefined,
    });
  };

  const onAlignmentSelect = (alignment) => {
    setAttributes({
      alignmentClass: alignment,
    });
  };

  const toggleContainer = (val) => {
    setAttributes({
      hasFixedContainer: val,
    });
  }

  const onPaddingSelect = (padding) => {
    setAttributes({
      paddingClass: padding,
    });
  };

  return (
    <Fragment>
      <InspectorControls>
        <PanelBody
          title={__('Background settings', 'post-layout-fll')}
          initialOpen={true}
        >
          <div className={className}>
            <MediaUploadCheck fallback={instructions}>
              <MediaUpload
                title={__('Background image', 'post-layout-fll')}
                onSelect={onUpdateImage}
                allowedTypes={ALLOWED_MEDIA_TYPES}
                value={bgImageId}
                render={({ open }) => (
                  <Button
                    className={!bgImageId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'}
                    onClick={open}>
                    { !bgImageId && (__('Set background image', 'post-layout-fll'))}
                    { !!bgImageId && !bgImage && <Spinner />}
                    { !!bgImageId && bgImage &&
                      <ResponsiveWrapper
                        naturalWidth={bgImage.media_details.width}
                        naturalHeight={bgImage.media_details.height}
                      >
                        <img src={bgImage.source_url} alt={__('Background image', 'post-layout-fll')} />
                      </ResponsiveWrapper>
                    }
                  </Button>
                )}
              />
            </MediaUploadCheck>
            {!!bgImageId && bgImage &&
              <MediaUploadCheck>
                <MediaUpload
                  title={__('Background image', 'post-layout-fll')}
                  onSelect={onUpdateImage}
                  allowedTypes={ALLOWED_MEDIA_TYPES}
                  value={bgImageId}
                  render={({ open }) => (
                    <Button onClick={open} isDefault isLarge>
                      { __('Replace background image', 'post-layout-fll')}
                    </Button>
                  )}
                />
              </MediaUploadCheck>
            }
            {!!bgImageId &&
              <MediaUploadCheck>
                <Button onClick={onRemoveImage} isLink isDestructive>
                  {__('Remove background image', 'post-layout-fll')}
                </Button>
              </MediaUploadCheck>
            }
          </div>
        </PanelBody>
        <PanelBody
          title={__('Layout settings', 'post-layout-fll')}
          initialOpen={false}
        >
          <PanelRow>
            <SelectControl
              label='Block layout alignment/size'
              value={attributes.alignmentClass}
              options={[
                { label: 'None (default)', value: 'alignone' },
                { label: 'Wide', value: 'alignwide' },
                { label: 'Full', value: 'alignfull' },
              ]}
              onChange={onAlignmentSelect}
              />
          </PanelRow>
          <PanelRow>
            <ToggleControl
              label='Fixed container'
              checked={hasFixedContainer}
              onChange={toggleContainer}
              />
          </PanelRow>
          <PanelRow>
            <SelectControl
              label='Block padding'
              value={attributes.paddingClass}
              options={[
                { label: 'Single', value: 'padding-single' },
                { label: 'Double', value: 'padding-double' },
                { label: 'None', value: 'padding-none' },
              ]}
              onChange={onPaddingSelect}
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
      <div
        className={`${className} ${alignmentClass} ${paddingClass}`}
        style={styles}
      >
        <InnerBlocks />
      </div>
    </Fragment>
  );
}

export default withSelect((select, ownProps) => {
  const { getMedia } = select('core');
  const { bgImageId } = ownProps.attributes;
  return {
    bgImage: bgImageId ? getMedia(bgImageId) : null,
  }
})(BlockWrapperEdit);