import { __ } from '@wordpress/i18n'
import { TimePicker } from '@wordpress/components'

export const EstTimePicker = ( { est, onChange } ) => {
	return (
		<TimePicker.TimeInput
			label={ __( '投稿する時刻', 'daily-preloma' ) }
			value={ { hours: 0, minutes: 0 } }
			onChange={ onChange }
		/>
	)
}
