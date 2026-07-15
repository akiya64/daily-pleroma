import { __ } from '@wordpress/i18n'
import { useEffect, useReducer } from '@wordpress/element'
import { useDispatch } from '@wordpress/data'
import { store as noticeStore } from '@wordpress/notices'
import apiFetch from '@wordpress/api-fetch'

export const useSettings = () => {

	const [ settings, setSettings ] = useReducer( ( prev, next ) => {
		return { ...prev, ...next }
	}, {
		rssUrl: '',
		digestAuthor: 1,
		digestCategory: 1,
		estDailyPost: { hours: 0, minutes: 0 }
	} )

	useEffect( () => {
		apiFetch( { path: '/wp/v2/settings' } ).then( ( { daily_pleroma_settings } ) => {
			const { rss_url, digest_author, digest_category, est_daily_post } = daily_pleroma_settings

			const [hours, minutes] = est_daily_post.split(':')

			setSettings( {
				rssUrl: rss_url,
				digestAuthor: digest_author,
				digestCategory: digest_category,
				estDailyPost: { hours: hours, minutes: minutes }
			} )
		} )
	}, [] )

	const { createSuccessNotice } = useDispatch( noticeStore )

	const saveSettings = () => {
		const { rssUrl, digestAuthor, digestCategory, estDailyPost } = settings
		const { hours, minutes } = estDailyPost

		apiFetch( {
			path: '/wp/v2/settings',
			method: 'POST',
			data: {
				daily_pleroma_settings: {
					rss_url: rssUrl,
					digest_author: digestAuthor,
					digest_category: digestCategory,
					est_daily_post: hours.toString().padStart( 2, "0" ) + ':' + minutes.toString().padStart( 2, "0" )
				}
			}
		} ).then( () => {
			createSuccessNotice(
				__( 'Save completed', 'daily-pleroma' )
			)
		} )
	}

	return { settings, setSettings, saveSettings }
}
