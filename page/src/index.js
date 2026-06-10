import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { AuthorSelector } from './components/AuthorSelector'
import { CategorySelector } from './components/CategorySelector'
import { EstTimePicker } from './components/EstTimePicker'
import { RssUrlControl } from './components/RssUrlControl'
import { useSettings } from './hooks/useSettings'

const SettingsPage = () => {
	const { settings, setSettings } = useSettings()
	const { rssUrl, digestAuthor, digestCategory, estDailyPost } = settings

	return (
		<div>
			<RssUrlControl
				url={ rssUrl }
				onChange={ (v) => setSettings({ rssUrl: v }) }
			/>
			<AuthorSelector
				author={ digestAuthor }
				onChange={ (v) => setSettings({ digestAuthor: v }) }
			/>
			<CategorySelector
				cat={ digestCategory }
				onChange={ (v) => setSettings({ digestCategory: v }) }
			/>
			<EstTimePicker
				est={ estDailyPost }
				onChange={ (v) => setSettings({ estDailyPost: v}) }
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
