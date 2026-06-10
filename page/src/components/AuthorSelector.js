import { __ } from '@wordpress/i18n'
import apiFetch from '@wordpress/api-fetch'
import { useEffect, useState } from '@wordpress/element'
import { SelectControl } from '@wordpress/components'

export const AuthorSelector = ( { author, onChange }) => {

	const [ options, setOptions ] = useState([]);

	useEffect( () => {
		apiFetch( { path: '/wp/v2/users' } ).then( ( users ) => {
			setOptions( users.map( ( user ) => { return { label:user.name, value:user.id  } } ))
		} )
	}, [] )

	return (
		<SelectControl
			label={ __( 'ダイジェストの所有者', 'daily-preloma' ) }
			value={ author }
			onChange={ onChange }
			options={ options }
		/>
	)
}

