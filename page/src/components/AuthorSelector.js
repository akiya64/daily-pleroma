import { __ } from '@wordpress/i18n'
import { SelectControl } from '@wordpress/components'

export const AuthorSelector = ( { user, onChange }) => {
	return (
		<SelectControl
			label={ __( 'ダイジェストの所有者', 'daily-preloma' ) }
			value={ user }
			onChange={ onChange }
			options={ [
				{ laebel: 'akkoma', value: '1' }
			] }
		/>
	)
}

