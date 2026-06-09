import { useState } from '@wordpress/element'

export const useSettings = () => {
	const [ rssUrl, setRssUrl ] = useState('')
	const [ digestAuthor, setDigestAuthor ] = useState(1)
	const [ digestCategory, setDigestCategory ] = useState(1)
	const [ estDailyPost, setEstDailyPost ] = useState( { hours: 0, minutes: 0 })

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
