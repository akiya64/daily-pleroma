import { __ } from '@wordpress/i18n'
import { SelectControl } from '@wordpress/components'

export const AuthorSelector = ( { author, onChange }) => {
	return (
		<SelectControl
			label={ __( 'ダイジェストの所有者', 'daily-preloma' ) }
			value={ author }
			onChange={ onChange }
			options={ [
				{ label: 'akiya', value: '1' }
			] }
		/>
	)
}

