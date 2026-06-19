import apiFetch from '@wordpress/api-fetch';
import { Button, DropZone } from '@wordpress/components';
import { useState } from '@wordpress/element';

export const ImportPanel = () => {
	const [ jsonFile, setJsonFile ] = useState(undefined)

	return jsonFile ? (
				<Button>アップロード</Button>
			) : (
				<div style={{
					background: 'lightgray',
					padding: 32,
					position: 'relative'
				  }} >
					outbox-json をここにドロップ
				<DropZone
					onFilesDrop={ (files)=>{ setJsonFile[files[0]]
						const formData = new FormData()
						formData.append(
							'outbox-json',
							files[0],
							files[0].name
						)

						apiFetch( {
							'path': '/daily-pleroma/v1/import-json',
							
							'method': 'POST',
							'body': formData
						} ).then().catch()
					} }
				/>
				</div>
			)
}
