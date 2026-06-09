import { __ } from '@wordpress/i18n'
import { SelectControl } from '@wordpress/components'

export const CategorySelector = ( { cat, onChange }) => {
	return (
		<SelectControl
			label={ __( 'ダイジェストのカテゴリー', 'daily-preloma' ) }
			value={ cat }
			onChange={ onChange }
			options={ [
				{ label: 'akkoma', value: '1' }
			] }
		/>
	)
}

