import { __ } from '@wordpress/i18n'
import apiFetch from '@wordpress/api-fetch'
import { useEffect, useState } from '@wordpress/element'
import { SelectControl } from '@wordpress/components'

export const CategorySelector = ( { cat, onChange }) => {

	const [ options, setOptions ] = useState([]);

	useEffect( () => {
		apiFetch( { path: '/wp/v2/categories' } ).then( ( categories ) => {
			setOptions( categories.map( ( cat ) => { return { label:cat.name, value:cat.id  } } ))
		} )
	}, [] )

	return (
		<SelectControl
			label={ __( 'Category for digest post', 'daily-preloma' ) }
			value={ cat }
			onChange={ onChange }
			options={ options }
		/>
	)
}

