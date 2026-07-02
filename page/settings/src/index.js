import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { __ } from '@wordpress/i18n'
import { TabPanel } from '@wordpress/components'
import { SettingsPanel } from './components/Tabs/SettingsPanel'
import { RssFetchPanel } from './components/Tabs/RssFetchPanel'

const SettingsPage = () => {
	return (
		<div
			style={{ maxWidth: '800px' }}
		>
			<TabPanel
				style={{ padding: 16 }}
				tabs={[
					{
						name: 'settings',
						title: __( 'Settings', 'daily-pleroma' )
					},
					{
						name: 'checkRss',
						title: __( 'Check RSS', 'daily-pleroma' )
					}
				]}
			>
				{ ( tab ) => {
					if( tab.name === 'settings' ){
						return <SettingsPanel />
					}
					if( tab.name ==='checkRss' ){
						return <RssFetchPanel />
					}
					return null
				} }

			</TabPanel>
		</div>
	)
}

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-settings' )
    )

    root.render( <SettingsPage /> )
} )
