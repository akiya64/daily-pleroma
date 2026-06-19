import { __ } from '@wordpress/i18n'
import { Button } from '@wordpress/components'
import { useState } from 'react';
import apiFetch from '@wordpress/api-fetch';

export const RssFetchResult = () => {
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
		<>
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
