import { __ } from '@wordpress/i18n'
import { Button } from '@wordpress/components'
import { useState } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const RssFetchPanel = () => {
	const [ result, setResult ] = useState([])
	const [ errorMessage, setErrorMessage ] = useState('')

	const fetchRss = () => {
		apiFetch( { path: '/daily-pleroma/v1/fetch-rss' } ).then( ( result ) => {
			setResult( result )
			setErrorMessage('')

		} ).catch( ( error ) => {
			setResult( [] )
			setErrorMessage( error.message )

		} )
	}

	return (
		<div style={{ paddingTop: 16 }}>
			<Button
				__next40pxDefaultSize
				variant="primary"
				onClick={ fetchRss }
			>
				{ __( 'Test read RSS from url', 'daily-pleroma' ) }
			</Button>
			<Result entries={ result } errorMessage={errorMessage} />
		</div>
	)
}

const Result = ( { entries, errorMessage } ) => {
	if( errorMessage ){
		return <p>{errorMessage}</p>

	} else if( entries.length > 0 ){
		const day = new Date( entries[0].date )
		return (
			<>
				<p>{day.getMonth() + 1}月{day.getDay()}日のエントリー</p>
				{ entries.map( ( { content, url }, index ) => {
						return (
							<p id={ index } dangerouslySetInnerHTML={
								{ __html: `${content} <a href="${url}">#</a>` }
							} />
					)
					} )
				}
			</>
		)
	} else {
		return null

	}
}
