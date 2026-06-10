import { __ } from '@wordpress/i18n'
import { Button } from '@wordpress/components'

export const SaveButton = ( { onClick } ) => {
	return (
		<Button variant="primary" onClick={ onClick } __next40pxDefaultSize>
			{ __( '設定を保存', 'daily-pleroma' ) }
		</Button>
	);
}
