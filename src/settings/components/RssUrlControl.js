import { __ } from '@wordpress/i18n'
import { TextControl } from '@wordpress/components'

export const RssUrlControl = ( { url, onChange } ) => {
	return (
		<TextControl
			label={ __( 'RSS URL in Pleroma or Akkoma', 'daily-preloma' ) }
			value={ url }
			onChange={ onChange }
		/>
	)
}

