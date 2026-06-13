import { __ } from '@wordpress/i18n'
import { Button } from '@wordpress/components'
import { useState } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const RssFetchResult = () => {
	const [ result, setResult ] = useState([])
	const [ errorMessage, setError ] = useState('')

	const fetchRss = () => {

		apiFetch( { path: '/daily-pleroma/v1/fetch-rss' } ).then( ( result ) => {
			setResult( result )
			setError('')
		} ).catch( ( error ) => {
			setResult( [] )
			setError( error )
		} )
	}

	return (
		<>
			<hr />
			<Button
				__next40pxDefaultSize
				variant="primary"
				onClick={ fetchRss }
			>
				{ __( 'RSS の読み込みテスト', 'daily-pleroma' ) }
			</Button>
			<Result entries={ result } errorMessage={errorMessage} />
		</>
	)
}

const Result = ( { entries, errorMessage } ) => {
	if( errorMessage ){
		return <p>{errorMessage}</p>

	} else if( entries.length > 0 ){
		return (
			<>
				<p> 月 日のエントリー</p>
				{ entries.map( ( { content, link }) => {
						return (
							<p>{content}<link href={link}>#</link></p>
					)
					} )
				}
			</>
		)
	} else {
		return null

	}
}
