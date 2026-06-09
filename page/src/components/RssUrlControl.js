import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';

export const RssUrlControl = ( { value, onChange }) => {
	return (
		<TextControl
			label={ __( 'rss の URL', 'daily-preloma' ) }
			value={ value }

			onChange={ onChange }

		/>
	)
}

