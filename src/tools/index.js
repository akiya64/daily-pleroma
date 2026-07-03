import domReady from '@wordpress/dom-ready'
import { createRoot } from '@wordpress/element'
import { ImportForm } from './ImportForm'

domReady( () => {
    const root = createRoot(
        document.getElementById( 'daily-pleroma-import-outbox' )
    )

    root.render( <ImportForm/> )
} )
