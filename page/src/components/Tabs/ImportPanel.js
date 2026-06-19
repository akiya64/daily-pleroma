import apiFetch from '@wordpress/api-fetch';
import { Button, DropZone } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { store as noticeStore } from "@wordpress/notices"
import { __ } from '@wordpress/i18n';

export const ImportPanel = () => {
	const [ jsonFile, setJsonFile ] = useState(undefined)
	const { createErrorNotice, createSuccessNotice } = useDispatch( noticeStore )

	const dropHandle = ( files ) => setJsonFile(files[0])
	const dropZoneText = jsonFile
		? jsonFile.name
		: __( 'outbox-json をここにドロップ', 'daily-pleroma' )

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
		} ).then().catch()
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

			{ jsonFile && 
				<Button
					variant= {'primary'}
					onClick={ onClickHandle }
				>
					アップロードしてダイジェストを投稿
				</Button>
			}
		</div>
	)
}
