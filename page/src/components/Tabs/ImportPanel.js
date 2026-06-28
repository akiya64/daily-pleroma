import apiFetch from '@wordpress/api-fetch';
import { Button, DropZone } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { store as noticeStore } from "@wordpress/notices"
import { __ } from '@wordpress/i18n';
import { Notices } from '../Notices'

export const ImportPanel = () => {
	const [ jsonFile, setJsonFile ] = useState(undefined)
	const { createErrorNotice, createSuccessNotice, removeAllNotices } = useDispatch( noticeStore )

	const dropHandle = ( files ) => {
		removeAllNotices()
		setJsonFile(files[0])
	}
	const dropZoneText = jsonFile
		? jsonFile.name
		: __( 'outbox.json をここにドロップ', 'daily-pleroma' )

	const onClickHandle = () => {
		const formData = new FormData()
		formData.append(
			'outbox-json',
			jsonFile,
			jsonFile.name
		)

		apiFetch( {
			'path': '/daily-pleroma/v1/import-json',
			'method': 'POST',
			'body': formData

		} ).then( ( res ) => {
			createSuccessNotice( res )
		} ).catch( ( error ) => {
			createErrorNotice( error.message )
		} )
	}

	return (
		<div style={{ marginTop: 16 }}>
			<Notices />

			<div style={{
				background: jsonFile ? 'white' : 'gainsboro',
				padding: 32,
				marginTop: 16,
				marginBottom: 16,
				position: 'relative'
			  }} >
				{ dropZoneText }
				<DropZone
					onFilesDrop={dropHandle}
				/>
			</div>

			<Button
				variant= {'primary'}
				onClick={ onClickHandle }
				disabled={ jsonFile ? false : true }
			>
				アップロードしてダイジェストを投稿
			</Button>
			<Button
				style={ { marginLeft: 32 } }
				variant= {'secondary'}
				onClick={ () => setJsonFile(null)  }
				disabled={ jsonFile ? false : true }
			>
				ファイルをクリア
			</Button>
		</div>
	)
}
