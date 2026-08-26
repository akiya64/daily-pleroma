import { __ } from '@wordpress/i18n'
import { Button } from '@wordpress/components'
import { useDispatch } from '@wordpress/data'
import { useSettings } from '../hooks/useSettings'
import { store as noticeStore } from "@wordpress/notices"
import apiFetch from '@wordpress/api-fetch';

export const PostDigestButton = () => {

	const { saveSettings } = useSettings()
	const { createSuccessNotice, createErrorNotice } = useDispatch( noticeStore )

	const onClickHandle = () => {
		saveSettings()

		apiFetch( {
			path: '/daily-pleroma/v1/post-digest',
			'method': 'POST'
		} ).then( ( result ) => {
			createSuccessNotice( result )
		} ).catch( ( error ) => {
			createErrorNotice( error.message )
		} )
	}

	return (
		<Button variant="primary" onClick={ onClickHandle } __next40pxDefaultSize>
			{ __( 'Post digest now', 'daily-pleroma' ) }
		</Button>
	);
}
