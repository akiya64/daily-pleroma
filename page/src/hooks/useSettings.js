import { useEffect, useState } from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch'

export const useSettings = () => {
	const [ rssUrl, setRssUrl ] = useState('')
	const [ digestAuthor, setDigestAuthor ] = useState(1)
	const [ digestCategory, setDigestCategory ] = useState(1)
	const [ estDailyPost, setEstDailyPost ] = useState( { hours: 0, minutes: 0 })

	useEffect( () => {
		apiFetch( { path: '/wp/v2/settings' } ).then( ( settings ) => {
			const { rss_url, digest_author, digest_category, est_daily_post } = settings.daily_pleroma_settings
			setRssUrl( rss_url )
			setDigestAuthor( digest_author )
			setDigestCategory( digest_category )

			const [hours, minutes] = est_daily_post.split(':')
			setEstDailyPost({ hours: hours, minutes: minutes })
		} )
	}, [] )

	return {
		rssUrl,
		setRssUrl,
		digestAuthor,
		setDigestAuthor,
		digestCategory,
		setDigestCategory,
		estDailyPost,
		setEstDailyPost
	}
}
