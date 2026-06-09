import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { AuthorSelector } from './components/AuthorSelector'
import { CategorySelector } from './components/CategorySelector'
import { EstTimePicker } from './components/EstTimePicker'
import { RssUrlControl } from './components/RssUrlControl'
import { useSettings } from './hooks/useSettings'

const SettingsPage = () => {
	const {
		rssUrl,
		setRssUrl,
		digestAuthor,
		setDigestAuthor,
		digestCategory,
		setDigestCategory,
		estDailyPost,
		setEstDailyPost
	} = useSettings()
	return (
		<div>
			<RssUrlControl
				url={ rssUrl }
				onChange={ (v)=>setRssUrl(v) }
			/>
			<AuthorSelector
				author={ digestAuthor }
				onChange={ (v) => setDigestAuthor(v) }
			/>
			<CategorySelector
				cat={ digestCategory }
				onChange={ (v) => setDigestCategory(v) }
			/>
			<EstTimePicker
				est={ estDailyPost }
				onChange={ (v) => setEstDailyPost(v) }
			/>
		</div>
	)
};

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-settings' )
    )

    root.render( <SettingsPage /> )
} )
