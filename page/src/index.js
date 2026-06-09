import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import { RssUrlControl } from './components/RssUrlControl'

const SettingsPage = () => {
    return <RssUrlControl />;
};

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-settings' )
    );

    root.render( <SettingsPage /> );
} );
