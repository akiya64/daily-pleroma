import apiFetch from '@wordpress/api-fetch';
import { Button, DropZone } from '@wordpress/components';
import { useState } from '@wordpress/element';

export const ImportPanel = () => {
	const [ jsonFile, setJsonFile ] = useState(undefined)

	const onClickHandle = () => {
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
	}

	return (
		<>
			<div style={{
				background: 'lightgray',
				padding: 32,
				marginTop: 32,
				position: 'relative'
			  }} >
				{ jsonFile
					? jsonFile.name
					: 'outbox-json をここにドロップ'
				}
				<DropZone
					onFilesDrop={ (files)=>{ setJsonFile(files[0]) } }
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
		</>
	)
}
