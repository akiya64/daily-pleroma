import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { __ } from '@wordpress/i18n'
import { TabPanel } from '@wordpress/components'
import { SettingsPanel } from './components/SettingsPanel'
import { ImportPanel } from './components/ImportPnael'

const SettingsPage = () => {
	return (
		<div 
			style={{
				maxWidth: '800px',
				backgroundColor: 'white',
				padding: '1em'
			}}
		>
			<Notices />
			<TabPanel
				
				tabs={[
					{
						name: 'settings',
						title: __( 'Settings', 'daily-pleroma' )
					},
					{
						name: 'import',
						title: __( 'Import Json', 'daily-pleroma' )
					}
				]}
			>
				{ ( tab ) => {
					if( tab.name === 'settings' ){
						return <SettingsPanel />
					}
					if( tab.name === 'import' ){
						return <ImportPanel />
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
