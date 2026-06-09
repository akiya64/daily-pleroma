import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { RssUrlControl } from './components/RssUrlControl'
import { AuthorSelector } from './components/AuthorSelector'
import { CategorySelector } from './components/CategorySelector'

const SettingsPage = () => {
	return (
		<div>
			<RssUrlControl />
			<AuthorSelector />
			<CategorySelector />
			<EstTimePicker />
		</div>
	)
};

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-settings' )
    )

    root.render( <SettingsPage /> )
} )
