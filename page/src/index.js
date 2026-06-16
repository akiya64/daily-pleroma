import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { AuthorSelector } from './components/AuthorSelector'
import { CategorySelector } from './components/CategorySelector'
import { EstTimePicker } from './components/EstTimePicker'
import { RssUrlControl } from './components/RssUrlControl'
import { RssFetchResult } from './components/RssFetchResult'
import { SaveButton } from './components/SaveButton'
import { Notices } from './components/Notices'
import { useSettings } from './hooks/useSettings'
import { JsonDropZone } from './components/JsonDropZone'

const SettingsPage = () => {
	const { settings, setSettings, saveSettings } = useSettings()
	const { rssUrl, digestAuthor, digestCategory, estDailyPost } = settings

	return (
		<div>
			<Notices />
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
			<SaveButton
				onClick={ saveSettings }
			/>
			<RssFetchResult />
			<JsonDropZone />
		</div>
	)
};

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-settings' )
    )

    root.render( <SettingsPage /> )
} )
